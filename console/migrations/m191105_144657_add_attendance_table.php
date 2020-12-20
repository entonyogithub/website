<?php

use yii\db\Migration;

/**
 * Class m191105_144657_add_attendance_table
 */
class m191105_144657_add_attendance_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%attendance_log}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'start_titme' => $this->string(11),
            'end_time' => $this->string(11),
            'duration' => $this->string(11),
            'date' => $this->date(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%attendance_log}}');
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m191105_144657_add_attendance_table cannot be reverted.\n";

      return false;
      }
     */
}
