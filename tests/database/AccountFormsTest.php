<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Database;

final class AccountFormsTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';

    protected function setUp(): void
    {
        config(Database::class)->defaultGroup = 'tests';
        parent::setUp();
    }

    public function testCustomerFormRejectsInvalidEmailAndKeepsValues(): void
    {
        $response = $this->post('customers', [
            csrf_token() => csrf_hash(),
            'full_name' => 'Ada Lovelace',
            'email' => 'not-an-email',
            'phone' => '12345',
        ]);

        $response->assertSee('Ada Lovelace');
        $response->assertSee('not-an-email');
        $response->assertSee('valid email');
        $this->assertSame(0, $this->db->table('customers')->countAllResults());
    }

    public function testUserFormEnforcesUniqueUsernameAndAllowsEditOfOwnUsername(): void
    {
        $this->db->table('users')->insert([
            'username' => 'ada', 'full_name' => 'Ada', 'created_at' => date('Y-m-d H:i:s'),
        ]);
        $id = $this->db->insertID();

        $duplicate = $this->post('users', [csrf_token() => csrf_hash(), 'username' => 'ada', 'full_name' => 'Another Ada']);
        $duplicate->assertSee('must contain a unique value');
        $this->assertSame(1, $this->db->table('users')->countAllResults());

        $updated = $this->post('users/' . $id, [csrf_token() => csrf_hash(), 'username' => 'ada', 'full_name' => 'Ada Updated']);
        $updated->assertRedirectTo('/users');
        $this->assertSame('Ada Updated', $this->db->table('users')->where('id', $id)->get()->getRow('full_name'));
    }

    public function testAvatarUploadCreatesSquareImageAndStoresFilenameOnly(): void
    {
        $this->db->table('users')->insert([
            'username' => 'grace', 'full_name' => 'Grace Hopper', 'created_at' => date('Y-m-d H:i:s'),
        ]);
        $id = $this->db->insertID();
        $temporary = tempnam(sys_get_temp_dir(), 'tfa3-avatar-');
        $image = imagecreatetruecolor(400, 200);
        imagepng($image, $temporary);
        imagedestroy($image);
        service('superglobals')->setFilesArray([
            'avatar' => [
                'name' => 'profile.png', 'type' => 'image/png', 'tmp_name' => $temporary,
                'error' => UPLOAD_ERR_OK, 'size' => filesize($temporary),
            ],
        ]);

        try {
            $response = $this->post('users/' . $id, [
                csrf_token() => csrf_hash(), 'username' => 'grace', 'full_name' => 'Grace Hopper',
            ]);
            $response->assertRedirectTo('/users');
            $filename = $this->db->table('users')->where('id', $id)->get()->getRow('avatar');
            $this->assertMatchesRegularExpression('/^[a-f0-9]{32}\.png$/', $filename);
            $path = FCPATH . 'uploads/avatars/' . $filename;
            $this->assertFileExists($path);
            $this->assertSame([256, 256], array_slice(getimagesize($path), 0, 2));
        } finally {
            service('superglobals')->setFilesArray([]);
            @unlink($temporary);
            if (isset($path)) {
                @unlink($path);
            }
        }
    }
}
