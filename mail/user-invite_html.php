<?php

use yii\helpers\Url;

?>

<h1><?=APPLICATION_NAME?></h1>

<h2>Hi <?=$user->first_name?>,</h2>

<p>You have been invited by <?=COMPANY_NAME?> to be a part of their Taskboard system!</p>

<p>Your Account has all been set up, you just need to activate your account following the link below and setting your password!</p>

<p>Your temporary password is: <?=$password?></p>

<!--INSERT VERIFICATION LINK HERE-->
<?= Url::to(['/site/verify-email', 'token' => $user->verification_token],'http') ?>