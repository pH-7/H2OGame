<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

require H2O_SERVER_PATH . 'library/PFBC/Form.php';

// Autoloading Classes Files
spl_autoload_register(function($sClass)
{
    // Hack to remove namespace and backslash
    $sClass = str_replace(array(__NAMESPACE__ . '\\', '\\'), '/', $sClass);

    // Get library classes
    if (is_file(H2O_SERVER_PATH . 'library/' . $sClass . '.class.php'))
        require_once H2O_SERVER_PATH . 'library/' . $sClass . '.class.php';
});
