<?php

use yii\helpers\Url;

?>

<?=APPLICATION_NAME?>

Hi <?=$user->first_name?>,

Your User Account has been updated for <?=COMPANY_NAME?>'s Taskboard system!</p>

If you initiated this change, then there is no need to worry. However, if you do not recognise this, then please contact the admin at <a href="mailto:<?=ADMIN_EMAIL?>"><?=ADMIN_EMAIL?></a>!</p>

Thank you

This email may contain viruses that could infect your computer. We strongly recommend using a malware scanner to check the contents of this email and its attachments, if there are any. Since emails can be lost, intercepted, or corrupted, <?=COMPANY_NAME?> accepts no liability for damages caused by viruses transmitted via this email.