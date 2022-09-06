<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' =>  'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'user_name' => [
                'type' =>  'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'full_name' => [
                'type' =>  'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => false
            ],
            'email' => [
                'type' =>  'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'phone_no' => [
                'type' =>  'VARCHAR',
                'constraint' => '15',
                'null' => false,
                'unique' => true
            ],
            'birth_day' => [
                'type' =>  'DATE',
                'null' => true,
                'unique' => false
            ],
            'created_by' => [
                'type' =>  'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => false
            ],
            'created_at datetime default current_timestamp',

            'changed_by' => [
                'type' =>  'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'unique' => false
            ],
            'updated_at datetime default current_timestamp',
            'deleted_at datetime default current_timestamp',
            'is_verified' => [
                'type' =>  'VARCHAR',
                'constraint' => '1',
                'null' => false,
                'unique' => false
            ],
            'is_deleted' => [
                'type' =>  'VARCHAR',
                'constraint' => '1',
                'null' => false,
                'unique' => false
            ],
            
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
