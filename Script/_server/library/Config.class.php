<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

final class Config
{

    const
    /*** SITE INFOS ***/
    SITE_NAME = '',
    SITE_SLOGAN = '',
    /* Meta tags */
    SITE_DESCRIPTION = '',
    SITE_KEYWORDS = '',

    /*** SQL INFO ***/
    DB_TYPE = 'mysql',
    DB_TYPE_NAME = 'MySQL', // RDBMS
    DB_HOST = '',
    DB_NAME = '',
    DB_USR = '',
    DB_PWD = '',
    DB_CHARSET = 'UTF8',
    DB_TABLE_PREFIX = '',

    /*** SESSION INFOS ***/
    SESSION_PREFIX = 'h2o_',
    SESSION_COOKIE_NAME = 'H2OSESS',
    SESSION_EXPIRATION = 7200,
    SESSION_PATH = '/',
    SESSION_DOMAIN = H2O_COOKIE_DOMAIN,

    /*** COOKIE INFOS ***/
    COOKIE_PREFIX = 'h2o_',
    COOKIE_EXPIRATION = 31536000,
    COOKIE_PATH = '/',
    COOKIE_DOMAIN = H2O_COOKIE_DOMAIN;

}
