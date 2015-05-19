<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

ini_set('log_errors' , 'On');
ini_set('error_log', H2O_SERVER_PATH . 'data/logs/php_error.log');
ini_set('ignore_repeated_errors', 'On');
