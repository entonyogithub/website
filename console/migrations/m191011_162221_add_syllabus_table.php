<?php

use yii\db\Migration;

/**
 * Class m191011_162221_add_syllabus_table
 */
class m191011_162221_add_syllabus_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%syllabus}}', [
            'id' => $this->primaryKey(),
            'class_id' => $this->integer(11)->notNull(),
            'title' => $this->string(255),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'df' => $this->boolean()->defaultValue(0),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%syllabus}}');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m191011_162221_add_syllabus_table cannot be reverted.\n";

      return false;
      }
     */
}
