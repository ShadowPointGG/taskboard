<?php
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Nav;
use yii\helpers\Html;
use app\models\Authentication as authy;

$items = [
    ['label' => 'Home', 'items'=> [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
    ]],

    ['label' => 'Admin Area', 'visible' => authy::isAdmin(), 'items'=>[
        ['label' => 'Dashboard', 'url' => ['/admin/index', 'visible'=>authy::isAdmin()]],
        ['label' => 'Invite Users', 'url' => ['/site/invite','visible' => authy::canCreateUser()]],
    ]],


    ['label' => 'User', 'visible' => !Yii::$app->user->isGuest, 'items'=>[
        ['label' => 'Profile', 'url' => ['/user/index','id'=>Yii::$app->user->id]],
        ['label' => 'LogOut', 'url' => ['/site/signout']],
    ]],

    ['label' => 'Login', 'url' => ['/site/login'], 'visible' => Yii::$app->user->isGuest]

//    Yii::$app->user->isGuest
//        ? ['label' => 'Login', 'url' => ['/site/login']]
//        : '<li class="nav-item">'
//        . Html::beginForm(['/site/logout'])
//        . Html::submitButton(
//            'Logout (' . Yii::$app->user->identity->username . ')',
//            ['class' => 'nav-link btn btn-link logout']
//        )
//        . Html::endForm()
//        . '</li>',


];

NavBar::begin([
    'brandLabel' => APPLICATION_NAME,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right ms-auto'],
    'items' => $items
]);
NavBar::end();

