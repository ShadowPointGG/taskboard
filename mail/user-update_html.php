<?php

use yii\helpers\Url;

?>

<h1><?=APPLICATION_NAME?></h1>

<h2>Hi <?=$user->first_name?>,</h2>

<p>Your User Account has been updated for <?=COMPANY_NAME?>'s Taskboard system!</p>

    <p>If you initiated this change, then there is no need to worry. However, if you do not recognise this, then please contact the admin at <a href="mailto:<?=ADMIN_EMAIL?>"><?=ADMIN_EMAIL?></a>!</p>

<p>Thank you</p>

This email may contain viruses that could infect your computer. We strongly recommend using a malware scanner to check the contents of this email and its attachments, if there are any. Since emails can be lost, intercepted, or corrupted, <?=COMPANY_NAME?> accepts no liability for damages caused by viruses transmitted via this email.