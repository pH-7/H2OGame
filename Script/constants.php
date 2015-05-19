<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

defined('H2O') or exit('Access denied');

//------------ Other ----------------//
define('H2O_REQUIRE_SERVER_VERSION', '5.4.0');
define('H2O_REQUIRE_SQL_VERSION', '5.0');
define('H2O_ENCODING', 'utf-8');
define('H2O_DEFAULT_TIMEZONE', 'America/Chicago');
define('H2O_DS', DIRECTORY_SEPARATOR);
define('H2O_PS', PATH_SEPARATOR);
define('H2O_DOT', '.');
define('H2O_WIDTH_SEARCH_FORM', 160);
define('H2O_ENVIRONMENT', true);

// URL association for SSL and protocol compatibility
$sHttp = (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
// Determines the domain name with the port
$sDomain = ($_SERVER['SERVER_PORT'] != '80') ?  $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_NAME'];
// Get domain that the cookie and cookie session is available (Set-Cookie: domain=your_site_name.com)
$sDomain_cookie = '.' . str_replace('www.', '', $sDomain);

//------------ URL ----------------//
define('H2O_PROTOCOL', $sHttp);
define('H2O_COOKIE_DOMAIN', $sDomain_cookie);
define('H2O_ROOT_URL', dirname(H2O_PROTOCOL . $sDomain . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES)) . '/'); // INSTALL URL
define('H2O_PUBLIC_DATA_URL', H2O_ROOT_URL  . 'data' . '/');

//----------- PATH -----------------//
define('H2O_ROOT_PATH', __DIR__ . H2O_DS); // PUBLIC ROOT
define('H2O_SERVER_PATH', H2O_ROOT_PATH . '_server' . H2O_DS);
define('H2O_PUBLIC_DATA_PATH', H2O_ROOT_PATH . 'data' . H2O_DS);

