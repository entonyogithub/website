<?php

use yii\db\Migration;

/**
 * Class m171120_132637_add_role_to_user
 */
class m171120_132637_add_role_to_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role', $this->string(255)->after('last_visit'));

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
       $this->addColumn('{{%user}}', 'role');
    }

}
