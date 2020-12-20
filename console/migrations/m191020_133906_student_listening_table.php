<?php

use yii\db\Migration;

/**
 * Class m191020_133906_student_listening_table
 */
class m191020_133906_student_listening_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%student_listening}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'class_id' => $this->integer(11)->notNull(),
            'upload_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%student_listening}}');
    }

}
