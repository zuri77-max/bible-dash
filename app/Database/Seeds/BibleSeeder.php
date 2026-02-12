<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BibleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'         => 'King James Version',
                'abbreviation' => 'KJV',
                'language'     => 'English',
                'description'  => 'The King James Version (KJV), also known as the Authorized Version, is an English translation of the Christian Bible.',
                'file_path'    => 'uploads/bibles/kjv.db',
                'file_size'    => 5242880, // 5MB example
                'version'      => '1.0',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'New International Version',
                'abbreviation' => 'NIV',
                'language'     => 'English',
                'description'  => 'The New International Version (NIV) is an English translation of the Bible.',
                'file_path'    => 'uploads/bibles/niv.db',
                'file_size'    => 4718592, // 4.5MB example
                'version'      => '2.0',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'English Standard Version',
                'abbreviation' => 'ESV',
                'language'     => 'English',
                'description'  => 'The English Standard Version (ESV) is an English translation of the Bible.',
                'file_path'    => 'uploads/bibles/esv.db',
                'file_size'    => 5000000,
                'version'      => '1.5',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'Reina Valera 1960',
                'abbreviation' => 'RVR60',
                'language'     => 'Spanish',
                'description'  => 'Reina-Valera 1960 is a Spanish translation of the Bible.',
                'file_path'    => 'uploads/bibles/rvr60.db',
                'file_size'    => 4800000,
                'version'      => '1.0',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'name'         => 'Louis Segond',
                'abbreviation' => 'LSG',
                'language'     => 'French',
                'description'  => 'The Louis Segond Bible is a French translation of the Holy Bible.',
                'file_path'    => 'uploads/bibles/lsg.db',
                'file_size'    => 4900000,
                'version'      => '1.0',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('bibles')->insertBatch($data);
        
        echo "✓ Bible versions seeded successfully!\n";
        echo "  - " . count($data) . " Bible versions added\n";
        echo "  - Languages: English, Spanish, French\n";
    }
}
