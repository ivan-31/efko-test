<?php

use yii\db\Migration;

/**
 * Class m210412_165919_add_full_name_to_user
 */
class m210412_165919_add_full_name_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'full_name', $this->string(150));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'full_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210412_165919_add_full_name_to_user cannot be reverted.\n";

        return false;
    }
    */
}
