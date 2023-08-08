<?php

use yii\db\Migration;

/**
 * Class m230808_155811_authInit
 */
class m230808_155811_authInit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        /**
         * User Management Roles
         */

        //userManager - createUsers
        $userCreate = $auth->createPermission("userCreate");
        $userCreate->description = "Can create Users";
        $auth->add($userCreate);

        //userManager - editUsers
        $userEdit = $auth->createPermission("userEdit");
        $userEdit->description = "Can edit Users";
        $auth->add($userEdit);

        //userManager - disableUsers
        $userDisable = $auth->createPermission("userDisable");
        $userDisable->description = "Can disable Users";
        $auth->add($userDisable);

        //userManager - userAdmin
        $userAdmin = $auth->createRole("userAdmin");
        $auth->add($userAdmin);
        $auth->addChild($userAdmin, $userCreate);
        $auth->addChild($userAdmin, $userEdit);
        $auth->addChild($userAdmin, $userDisable);

        /**
         * Task Management Roles
         */

        //taskManager - createTasks
        $taskCreate = $auth->createPermission("taskCreate");
        $taskCreate->description = "Can create Tasks";
        $auth->add($taskCreate);

        //taskManager - updateTasks
        $taskUpdate = $auth->createPermission("taskUpdate");
        $taskUpdate->description = "Can update Tasks";
        $auth->add($taskUpdate);

        //taskManager - deleteTasks
        $taskDelete = $auth->createPermission("taskDelete");
        $taskDelete->description = "Can delete Tasks";
        $auth->add($taskDelete);

        //taskManager - taskAdmin
        $taskAdmin = $auth->createRole("taskAdmin");
        $auth->add($taskAdmin);
        $auth->addChild($taskAdmin, $taskCreate);
        $auth->addChild($taskAdmin, $taskUpdate);
        $auth->addChild($taskAdmin, $taskDelete);

        /**
         * System Management Roles
         */

        //globalAdmin
        $globalAdmin = $auth->createRole("globalAdmin");
        $auth->add($globalAdmin);
        $auth->addChild($globalAdmin, $taskAdmin);
        $auth->addChild($globalAdmin, $userAdmin);


        /**
         * Add global Admin roles to User ID 1
         */

        $auth->assign($globalAdmin, 1);
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
