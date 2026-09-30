<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Users extends BaseController
{
    public function index(): string
    {
        return view('users/index', [
            'title' => 'POS Lab | User Accounts',
            'heading' => 'User Accounts',
            'users' => (new UserModel())->findAll(),
        ]);
    }

    public function new(): string
    {
        return $this->form();
    }

    public function create(): string|RedirectResponse
    {
        $data = $this->input();
        if (! $this->validateData($data, $this->rules())) {
            return $this->form(null, $data, $this->validator->getErrors());
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        (new UserModel())->insert($data + ['created_at' => date('Y-m-d H:i:s')]);

        return redirect()->to('/users')->with('success', 'User created.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())->find($id);
        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->form($user);
    }

    public function update(int $id): string|RedirectResponse
    {
        $model = new UserModel();
        $user = $model->find($id);
        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->input();
        if (! $this->validateData($data, $this->rules($id))) {
            return $this->form($user, $data, $this->validator->getErrors());
        }

        if ($data['password'] === '') {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $avatar = $this->request->getFile('avatar');
        if ($avatar !== null && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $this->validateData([], [
                'avatar' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]|max_size[avatar,2048]',
            ])) {
                return $this->form($user, $data, $this->validator->getErrors());
            }

            $filename = bin2hex(random_bytes(16)) . ($avatar->getMimeType() === 'image/png' ? '.png' : '.jpg');
            $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR;
            if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
                throw new \RuntimeException('Could not create the avatar upload directory.');
            }

            service('image')->withFile($avatar->getTempName())->fit(256, 256)->save($directory . $filename, 85);
            $data['avatar'] = $filename;
        }

        try {
            $model->update($id, $data);
        } catch (\Throwable $exception) {
            if (isset($filename)) {
                @unlink($directory . $filename);
            }
            throw $exception;
        }

        if (isset($filename) && ! empty($user['avatar'])) {
            @unlink($directory . basename($user['avatar']));
        }

        return redirect()->to('/users')->with('success', 'User updated.');
    }

    private function input(): array
    {
        return [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'password' => (string) $this->request->getPost('password'),
        ];
    }

    private function rules(?int $id = null): array
    {
        $unique = $id === null ? 'is_unique[users.username]' : 'is_unique[users.username,id,' . $id . ']';

        return [
            'username' => 'required|max_length[50]|' . $unique,
            'full_name' => 'required|max_length[100]',
            'password' => $id === null ? 'required|min_length[8]|max_length[255]' : 'permit_empty|min_length[8]|max_length[255]',
        ];
    }

    private function form(?array $user = null, ?array $values = null, array $errors = []): string
    {
        return view('users/form', [
            'title' => $user === null ? 'POS Lab | New User' : 'POS Lab | Edit User',
            'user' => $user,
            'values' => $values ?? $user ?? ['username' => '', 'full_name' => '', 'password' => ''],
            'errors' => $errors,
        ]);
    }
}
