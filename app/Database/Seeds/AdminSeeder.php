<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $users = auth()->getProvider();

        // Create admin user
        $user = new User([
            'username' => 'admin',
            'email'    => 'admin@bibleapi.com',
            'password' => 'admin123',  // Change this password after first login
        ]);
        $users->save($user);

        // Add to admin group
        $user = $users->findById($users->getInsertID());
        $user->addGroup('admin');

        echo "Admin user created successfully!\n";
        echo "Email: admin@bibleapi.com\n";
        echo "Password: admin123\n";
        echo "⚠️  Please change this password after first login!\n";
    }
}
