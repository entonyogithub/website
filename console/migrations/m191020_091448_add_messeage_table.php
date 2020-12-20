<?php

use yii\db\Migration;

/**
 * Class m191020_091448_add_messeage_table
 */
class m191020_091448_add_messeage_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'to_uid' => $this->integer(11)->notNull(),
            'message' => $this->text(),
            'read' => $this->boolean()->defaultValue(0),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'df' => $this->boolean()->defaultValue(0),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%message}}');
    }

}
