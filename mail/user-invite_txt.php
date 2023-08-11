<?php

use yii\helpers\Url;

?>

<?=APPLICATION_NAME?>

Hi <?=$user->first_name?>,

You have been invited by <?=COMPANY_NAME?> to be a part of their Taskboard system!

Your Account has all been set up, you just need to activate your account following the link below and setting your password!

Your temporary password is: <?=$password?>
<!--INSERT VERIFICATION LINK HERE-->
<?= Url::to(['/site/verify-email','token'=>$user->verification_token], 'http') ?>