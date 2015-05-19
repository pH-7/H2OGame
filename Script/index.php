<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

define('H2O', 1);

ob_start();

header('Content-Type: text/html; charset=utf-8');

require 'constants.php';
require 'requirements.php';

include H2O_ROOT_PATH . '_server/inc/log.inc.php';

include_once H2O_ROOT_PATH . '_server/inc/fns/misc.php';
require_once H2O_ROOT_PATH . '_server/inc/loader.inc.php';

require H2O_ROOT_PATH . '_server/app/Bootstrap.php';

ob_end_flush();

