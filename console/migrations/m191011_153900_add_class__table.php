<?php

use yii\db\Migration;

/**
 * Class m191011_153900_add_class__table
 */
class m191011_153900_add_class__table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%class}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'title' => $this->string(255),
            'total_number_of_lectures' => $this->integer(11),
            'taken_lectures' => $this->integer(11)->defaultValue(0),
            'total_number_of_recording' => $this->integer(11),
            'total_number_of_listening' => $this->integer(11),
            'listening_duration' => $this->integer(11),
            'recording_duration' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'df' =>  $this->boolean()->defaultValue(0),
                ], $tableOptions);
        $this->addForeignKey('FK_class_uid', '{{%class}}', 'uid', '{{%user}}', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
       $this->dropTable('{{%class}}');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m191011_153900_add_class__table cannot be reverted.\n";

      return false;
      }
     */
}
