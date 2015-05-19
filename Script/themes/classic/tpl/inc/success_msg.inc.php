<?php defined('H2O') or exit('Access denied');

$oSess = new H2O\Session;
if ($oSess->exists('H2OSuccessMsg'))
{
    echo '<div class="center alert-message success">' . $oSess->get('H2OSuccessMsg') . '</div>';
    $oSess->remove('H2OSuccessMsg');
}
unset($oSess);
