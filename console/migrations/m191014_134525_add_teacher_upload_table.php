<?php

use yii\db\Migration;

/**
 * Class m191014_134525_add_teacher_upload_table
 */
class m191014_134525_add_teacher_upload_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%teacher_upload}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'class_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255),
            'type' =>$this->smallInteger(1),
            'file' => $this->string(255),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'df' => $this->boolean()->defaultValue(0),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%teacher_upload}}');
    }

}
