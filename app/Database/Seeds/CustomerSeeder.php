<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $createdAt = date('Y-m-d H:i:s');

        $this->db->table('customers')->insertBatch([
            ['full_name' => 'Cedrick Vales', 'email' => 'cedrick.vales@example.com', 'phone' => '0967-676-7676', 'created_at' => $createdAt],
            ['full_name' => 'Joseph Bondoc', 'email' => 'joseph.bondoc@example.com', 'phone' => '0967-676-7676', 'created_at' => $createdAt],
            ['full_name' => 'Philyip Caluag', 'email' => 'philyip.caluag@example.com', 'phone' => '0967-676-7676', 'created_at' => $createdAt],
            ['full_name' => 'Lexus Medina', 'email' => 'lexus.medina@example.com', 'phone' => '0967-676-7676', 'created_at' => $createdAt],
            ['full_name' => 'Raining Odarbe', 'email' => 'raining.odarbe@example.com', 'phone' => '0967-676-7676', 'created_at' => $createdAt],
        ]);
    }
}
