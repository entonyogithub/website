<?php

use yii\db\Migration;

/**
 * Class m191027_154213_alter_class_table
 */
class m191027_154213_alter_class_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn("{{%class}}", "enable_iam_in", $this->boolean(common\models\Enum::ANSWER_NO)->after("show_payment"));

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
