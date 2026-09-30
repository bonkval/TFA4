<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function login(): string|RedirectResponse
    {
        if (session()->get('user') !== null) {
            return redirect()->to(site_url('customers'));
        }

        return view('auth/login', [
            'title' => 'POS Lab | Staff Login',
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function attemptLogin(): string|RedirectResponse
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('error', 'Enter your username and password.');
        }

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->to(site_url('login'))
                ->withInput()
                ->with('error', 'The username or password is incorrect.');
        }

        session()->regenerate(true);
        session()->set('user', [
            'id' => $user['id'],
            'username' => $user['username'],
            'full_name' => $user['full_name'],
        ]);

        return redirect()->to(site_url('customers'))->with('success', 'Welcome back.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();

        return redirect()->to(site_url('login'))->with('logout_message', 'You have been logged out.');
    }
}
