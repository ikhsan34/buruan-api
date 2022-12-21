<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class History extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'desc' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'deadline' => [
                'type' => 'datetime',
                'null' => false,
            ],
        'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('history');
    }

    public function down()
    {
        $this->forge->dropTable('history');
    }
}
