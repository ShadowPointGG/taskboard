<?php

use yii\helpers\Url;

if (!headers_sent()) {
    header('Refresh:5;url='. Url::to(['/site/login']));
}

Yii::$app->session->setFlash('success', "THIS ACCOUNT HAS ALREADY BEEN VERIFIED. REDIRECTING TO LOGIN");
?>

<h4>If nothing happens after 5 seconds, please click <a href="<?=Url::to(['/site/login'])?>">here</a> to go to the login page!</h4>