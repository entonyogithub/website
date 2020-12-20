<?php

use yii\db\Migration;

/**
 * Class m191027_154213_alter_class_table
 */
class m191105_144800_alter_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->alterColumn("{{%assignment}}", "title", $this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn("{{%class}}", "enable_iam_in");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191027_154213_alter_class_table cannot be reverted.\n";

        return false;
    }
    */
}
