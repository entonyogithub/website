<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'activation_code'=>Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'last_visit' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'df' => Schema::TYPE_BOOLEAN.' DEFAULT 0',
        ], $tableOptions);
        $this->insert('{{%user}}',[
            'email'=>'admin@hellospring.net',
            'password_hash'=>'$2y$13$.K9f58QPTRsOYd6H/YSiLe/jwSuqZHPnfSI5IQBiUzUOY0nPFXgqu',
            'auth_key'=>'',
            'activation_code'=>'',
            'status'=>1,
            'last_visit'=>0,
            'created_at'=>time(),
            'updated_at'=>time(),
            ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}

