<?php

use yii\db\Migration;

/**
 * Class m210411_180951_add_role_to_user
 */
class m210411_180951_add_role_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210411_180951_add_role_to_user cannot be reverted.\n";

        return false;
    }
    */
}
