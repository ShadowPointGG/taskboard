<?php

use yii\db\Migration;

/**
 * Class m230808_155811_authInit
 */
class m230808_155811_authInit extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        /**
         * Team Member Role
         */

        $teamMember = $auth->createRole('teamMember');
        $teamMember->name = "Team Member";
        $auth->add($teamMember);

        /**
         * EBoard Role
         */

        $eBoard = $auth->createRole('eboard');
        $eBoard->name ='SPGG EBoard Member';
        $auth->add($eBoard);

        /**
         * Admin Role - Fusco Role with access to all systems. eBoard won't have full access to some features, like approving financial requests
         */

        $admin = $auth->createRole('admin');
        $admin->name="Administrator";
        $auth->add($admin);
        $auth->addChild($admin, $eBoard);

        /**
         * System Admin - Full system access. Includes Site Error Logs and analytics - Jons Role
         */

        $sudo = $auth->createRole('sudo');
        $sudo->name="System Administrator";
        $auth->add($sudo);
        $auth->addChild($sudo, $admin);

        /**
         * Add System Admin roles to User ID 1
         */

        $auth->assign($sudo, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230808_155811_authInit cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230808_155811_authInit cannot be reverted.\n";

        return false;
    }
    */
}
