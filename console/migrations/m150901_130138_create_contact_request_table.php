<?php

use yii\db\Schema;
use yii\db\Migration;

class m150901_130138_create_contact_request_table extends Migration {

    public function up() {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%contact_request}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING,
            'subject' => Schema::TYPE_TEXT,
            'read' => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'df' => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
                ], $tableOptions);
    }

    public function down() {
          $this->dropTable('{{%contact_request}}');
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
