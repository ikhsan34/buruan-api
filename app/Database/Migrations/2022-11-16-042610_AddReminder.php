<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddReminder extends Migration
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
                'null' => false
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
            'reminded' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        'created_at datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('group_id', 'user_group', 'id');
        $this->forge->addForeignKey('user_id', 'user', 'id');
        $this->forge->createTable('reminder');
    }

    public function down()
    {
        $this->forge->dropTable('reminder');
    }
}
