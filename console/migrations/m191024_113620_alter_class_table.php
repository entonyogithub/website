<?php

use yii\db\Migration;

/**
 * Class m191024_113620_alter_class_table
 */
class m191024_113620_alter_class_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        $this->addColumn("{{%class}}", "iam_in_listenings", $this->integer(11)->after("rating"));
        $this->addColumn("{{%class}}", "iam_in_uploads", $this->integer(11)->after("iam_in_listenings"));
        $this->addColumn("{{%class}}", "show_payment", $this->boolean(common\models\Enum::ANSWER_NO)->after("iam_in_uploads"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn("{{%class}}", "iam_in_listenings");
        $this->dropColumn("{{%class}}", "iam_in_uploads");
        $this->dropColumn("{{%class}}", "show_payment");
    }

}
