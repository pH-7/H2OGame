<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Admin
{

    /**
     * Admins'levels.
     *
     * @return boolean
     */
    public static function auth()
    {
        $oSess = new Session;
        return ($oSess->exists('admin_id') && $oSess->get('admin_ip') === client_ip() && $oSess->get('admin_http_user_agent') === user_agent());
    }

    /**
     * Get the current admin's language.
     *
     * @return string
     */
    public static function getLang()
    {
        $oSess = new Session;
        return (new MainModel)->getAdminLang($oSess->get('admin_id'));
    }

    /**
     * Logout the admin.
     *
     * @param mixed (boolean | string) $mOverrideMsg Default FALSE
     * @param object \H2O\Session $oSession
     * @return void
     */
    public static function logout(Session $oSession, $mOverrideMsg = false)
    {
        $oSession->destroy();
        redirect('?m=admin&a=login', (!$mOverrideMsg ? trans('You have been successfully logged out') : $mOverrideMsg) ); // Redirect the admin to the login page
    }

}

