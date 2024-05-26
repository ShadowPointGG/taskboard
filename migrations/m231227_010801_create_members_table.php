<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%members}}`.
 */
class m231227_010801_create_members_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%members}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%members}}');
    }
}
