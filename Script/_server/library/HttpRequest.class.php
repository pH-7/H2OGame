<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class HttpRequest
{

    public function get($sKey)
    {
        return (!empty($_GET[$sKey])) ? escape($_GET[$sKey], true) : '';
    }

    public function post($sKey)
    {
        return (!empty($_POST[$sKey])) ? escape($_POST[$sKey], true) : '';
    }

    public function request($sKey)
    {
        return (!empty($_REQUEST[$sKey])) ? escape($_REQUEST[$sKey], true) : '';
    }

}