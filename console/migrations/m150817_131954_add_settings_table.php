<?php

use yii\db\Schema;
use yii\db\Migration;

class m150817_131954_add_settings_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%setting}}', [
            'id' => Schema::TYPE_PK,
            'uid' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING,
            'value' => Schema::TYPE_TEXT,
            'type' => Schema::TYPE_BOOLEAN,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'df' => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
                ], $tableOptions);
        $this->addForeignKey('FK_setting_table_uid', '{{%setting}}', 'uid', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');

    }

   public function down() {
        $this->dropTable('{{%setting}}');
    }
    
}
