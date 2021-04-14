<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%elevators}}`.
 */
class m210414_105655_create_elevators_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%elevators}}', [
            'e_id'             => $this->primaryKey(),
            'e_elevator'       => $this->string(77)->notNull(),
            'e_discription'    => $this->text()->notNull(),
            'e_operated_by'    => $this->string(77)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%elevators}}');
    }
}
