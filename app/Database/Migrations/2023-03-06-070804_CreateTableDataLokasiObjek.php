<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableDataLokasiObjek extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'latitude' => [
                'type' => 'DECIMAL(10,7)',
                'null' => false,
            ],
            'longitude' => [
                'type' => 'DECIMAL(10,7)',
                'null' => false,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('datalokasiobjek');
    }

    public function down()
    {
        $this->forge->dropTable('datalokasiobjek');
    }
}
