<?php

namespace App\Controllers;

class SetupController extends BaseController
{
    public function createBiblesTable()
    {
        $forge = \Config\Database::forge();
        
        // Drop table if exists
        $forge->dropTable('bibles', true);
        
        // Create table
        $forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'abbreviation' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'language' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'file_size' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            'version' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $forge->addKey('id', true);
        $forge->addKey('language');
        $forge->addKey('is_active');
        $forge->createTable('bibles');
        
        return 'Bibles table created successfully!';
    }
}
