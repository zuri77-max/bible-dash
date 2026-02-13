<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileHashToBiblesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('bibles', [
            'file_hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,
                'null'       => true,
                'comment'    => 'SHA256 hash of the file',
            ],
            'file_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
                'comment'    => 'File extension (json, db, etc)',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('bibles', ['file_hash', 'file_type']);
    }
}
