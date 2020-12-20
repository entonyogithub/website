<?php

use yii\db\Migration;

/**
 * Class m191020_141616_migrate_alter_student_class_table
 */
class m191020_141616_migrate_alter_student_class_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn("{{%class}}", "minimum_uploads", $this->integer(11)->after("taken_lectures"));
        $this->addColumn("{{%class}}", "minimum_listening", $this->integer(11)->after("minimum_uploads"));
        $this->addColumn("{{%class}}", "rating", $this->integer(11)->after("minimum_listening"));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn("{{%class}}", "minimum_uploads");
        $this->dropColumn("{{%class}}", "minimum_listening");
        $this->dropColumn("{{%class}}", "rating");
    }

}
