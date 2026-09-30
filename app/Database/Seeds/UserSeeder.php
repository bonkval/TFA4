<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $createdAt = date('Y-m-d H:i:s');

        $this->db->table('users')->insertBatch([
            ['username' => 'cvales', 'full_name' => 'Cedrick Vales', 'password' => password_hash('password', PASSWORD_DEFAULT), 'created_at' => $createdAt],
            ['username' => 'jbondoc', 'full_name' => 'Joseph Bondoc', 'password' => password_hash('password', PASSWORD_DEFAULT), 'created_at' => $createdAt],
            ['username' => 'pcaluag', 'full_name' => 'Philyip Caluag', 'password' => password_hash('password', PASSWORD_DEFAULT), 'created_at' => $createdAt],
            ['username' => 'lmedina', 'full_name' => 'Lexus Medina', 'password' => password_hash('password', PASSWORD_DEFAULT), 'created_at' => $createdAt],
            ['username' => 'rodarbe', 'full_name' => 'Raining Odarbe', 'password' => password_hash('password', PASSWORD_DEFAULT), 'created_at' => $createdAt],
        ]);
    }
}
