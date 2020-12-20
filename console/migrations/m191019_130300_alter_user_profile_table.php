<?php

use yii\db\Migration;

/**
 * Class m191019_130300_alter_user_profile_table
 */
class m191019_130300_alter_user_profile_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%user_profile}}', 'date_of_birth', $this->date()->after('mobile'));
        $this->addColumn('{{%user_profile}}', 'address', $this->text()->after('date_of_birth'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->addColumn('{{%user_profile}}', 'date_of_birth');
        $this->addColumn('{{%user_profile}}', 'address');
    }

}
