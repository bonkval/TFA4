<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToUsers extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('users', [
            'password' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'full_name'],
        ]);

        foreach ($this->db->table('users')->select('id')->get()->getResultArray() as $user) {
            $this->db->table('users')->where('id', $user['id'])->update([
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ]);
        }

        $this->forge->modifyColumn('users', ['password' => ['type' => 'VARCHAR', 'constraint' => 255]]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('users', 'password');
    }
}
