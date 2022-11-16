<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GroupMembership extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11
            ],
        ]);
        $this->forge->addForeignKey('group_id', 'user_group', 'id');
        $this->forge->addForeignKey('user_id', 'user', 'id');
        $this->forge->createTable('group_membership');
    }

    public function down()
    {
        //
        $this->forge->dropTable('group_membership');
    }
}
