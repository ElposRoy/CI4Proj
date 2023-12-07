<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ticket extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'INT', // INT(11)
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'office_id' => [
                'type' => 'INT', // INT(11)
                'constraint' => 11,
                'unsigned' => true,
               
            ],
            'first_name' => [
                'type' => 'VARCHAR', // VARCHAR(255)
                'constraint' => 255,
                'null' => false,
            ],
            'last_name' => [
                'type' => 'VARCHAR', // VARCHAR(255)
                'constraint' => 255,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR', // VARCHAR(255)
                'constraint' => 255,
                'null' => false,
            ],

            'state' => [
                'type' => 'ENUM', // Define as ENUM type
                'constraint' => ['pending', 'processing', 'resolved'], // Allowed values
                'null' => false,
            ],
            'severity' => [
                'type' => 'ENUM', // Define as ENUM type
                'constraint' => ['low', 'moderate', 'high', 'critical'], // Allowed values
                'null' => false,
            ],
            'description' => [
                'type' => 'VARCHAR', // VARCHAR(255)
                'constraint' => 255,
                'null' => false,
            ],
            'remarks' => [
                'type' => 'VARCHAR', // VARCHAR(255)
                'constraint' => 255,
                'null' => false,
            ],


            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addforeignKey('office_id', 'offices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
