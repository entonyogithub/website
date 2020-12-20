<?php

use yii\db\Schema;
use yii\db\Migration;

class m150623_122836_create_profile_table extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%profile}}', [
            'id' => Schema::TYPE_PK,
            'uid' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'name' => Schema::TYPE_STRING,
            'mobile' => Schema::TYPE_STRING,
            'photo' => Schema::TYPE_STRING,
            'date_of_birth' => Schema::TYPE_DATE,
                ], $tableOptions);
        $this->addForeignKey('FK_profile_uid', '{{%profile}}', 'uid', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');
        $this->insert('{{%profile}}',[
            'uid'=>1,
            'name'=>'Admin',
            'mobile'=>'00962795095511',
            'photo'=>'55f82b9a080af.png',
            ]);
    }

    public function down() {
        $this->dropTable('{{%profile}}');
    }

}
