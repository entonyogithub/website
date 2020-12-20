<?php

use yii\db\Migration;

/**
 * Class m191020_152706_add_weekly_meeting_member
 */
class m191020_152706_add_weekly_meeting_member extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%iam_in_member}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->integer(11)->notNull(),
            'class_id' => $this->integer(11)->notNull(),
            'listening_count' => $this->integer(11),
            'recording_count' => $this->integer(11),
            'coming' => $this->boolean(11)->defaultValue(common\models\Enum::ANSWER_NO),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
            'df' => $this->boolean()->defaultValue(0),
                ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('{{%iam_in_member}}');
    }

}
