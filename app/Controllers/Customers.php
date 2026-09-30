<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\HTTP\RedirectResponse;

class Customers extends BaseController
{
    public function index(): string
    {
        return view('customers/index', [
            'title' => 'POS Lab | Customer Accounts',
            'heading' => 'Customer Accounts',
            'customers' => (new CustomerModel())->findAll(),
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

        (new CustomerModel())->insert($data + ['created_at' => date('Y-m-d H:i:s')]);

        return redirect()->to('/customers')->with('success', 'Customer created.');
    }

    public function edit(int $id): string
    {
        $customer = (new CustomerModel())->find($id);
        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->form($customer);
    }

    public function update(int $id): string|RedirectResponse
    {
        $model = new CustomerModel();
        $customer = $model->find($id);
        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $this->input();
        if (! $this->validateData($data, $this->rules())) {
            return $this->form($customer, $data, $this->validator->getErrors());
        }

        $model->update($id, $data);

        return redirect()->to('/customers')->with('success', 'Customer updated.');
    }

    private function input(): array
    {
        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
        ];
    }

    private function rules(): array
    {
        return [
            'full_name' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|max_length[20]',
        ];
    }

    private function form(?array $customer = null, ?array $values = null, array $errors = []): string
    {
        return view('customers/form', [
            'title' => $customer === null ? 'POS Lab | New Customer' : 'POS Lab | Edit Customer',
            'customer' => $customer,
            'values' => $values ?? $customer ?? ['full_name' => '', 'email' => '', 'phone' => ''],
            'errors' => $errors,
        ]);
    }
}
