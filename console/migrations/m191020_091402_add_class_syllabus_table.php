<?php

use yii\db\Migration;

/**
 * Class m191020_091402_add_class_syllabus_table
 */
class m191020_091402_add_class_syllabus_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%class_syllabus}}', [
            'id' => $this->primaryKey(),
            'class_id' => $this->integer(11)->notNull(),
            'record_id' => $this->integer(11)->notNull(),
            'date' => $this->date(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'df' => $this->boolean()->defaultValue(0),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%class_syllabus}}');
    }

}
