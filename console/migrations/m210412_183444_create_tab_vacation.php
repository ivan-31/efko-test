<?php

use yii\db\Migration;

/**
 * Class m210412_183444_create_tab_vacation
 */
class m210412_183444_create_tab_vacation extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%vacation}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'date_start' => $this->date()->notNull(),
            'date_end' => $this->date()->notNull(),
            'fixed' => $this->boolean()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->addForeignKey('fk_user_id', '{{%vacation}}', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%vacation}}');
        $this->dropForeignKey('fk_user_id', '{{%vacation}}');
    }
}
