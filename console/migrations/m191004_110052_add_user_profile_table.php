<?php

use yii\db\Migration;

/**
 * Class m191004_110052_add_user_profile_table
 */
class m191004_110052_add_user_profile_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'mobile' => $this->string(255),
            'balance' => $this->float(),
                ], $tableOptions);
        $this->addForeignKey('FK_user_profile_uid', '{{%user_profile}}', 'uid', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
       $this->dropTable('{{%user_profile}}');
    }
}
