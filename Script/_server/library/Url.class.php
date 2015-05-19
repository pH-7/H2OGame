<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Url
{

    /**
     * Private constructor to prevent instantiation of class since it is a private class.
     *
     * @access private
     */
    private function __construct() {}

    /**
     * URL-encodes string.
     *
     * @static
     * @param string $sUrl
     * @return string
     */
    public static function encode($sUrl)
    {
        return urlencode($sUrl);
    }

    /**
     * Decodes URL-encoded string.
     *
     * @static
     * @param string $sUrl
     * @return string
     */
    public static function decode($sUrl)
    {
        return urldecode($sUrl);
    }

    /**
     * Clean a URL.
     *
     * @static
     * @param string $sUrl
     * @return string
     */
    public static function clean($sUrl)
    {
        return str_replace(array(' ', '&'), array('%20', '&amp;'), $sUrl);
    }

    /**
     * Clean URL.
     *
     * @static
     * @param string $sUrl
     * @param boolean $bFullClean Also removes points, puts characters to lowercase, etc. Default TRUE
     * @return string The new clean URL
     */
    public static function parseClean($sUrl, $bFullClean = true)
    {
        $sUrl = preg_replace( '/[\s]+/', '-', $sUrl);
        $sUrl = str_replace(array('«', '»', '"', '~', '#', '$', '@', '`', '§', '$', '£', 'µ', '\\', '[', ']', '<', '>', '%', '*', '{', '}'), '-', $sUrl);

        if ($bFullClean)
        {
            $sUrl = str_replace(array('.', '^', ',', ':', ';', '!'), '', $sUrl);
            $sUrl = mb_strtolower($sUrl);
            $sUrl = escape($sUrl, true);
        }

        return $sUrl;
    }


    /**
     * Generate URL-encoded query string.
     *
     * N.B.: We recreate our own function with default parameters (because the default parameters of PHP we do not like;))
     *
     * @static
     * @param array $aParams
     * @param string $sNumericPrefix Default NULL
     * @param string $sArgSeparator Default '&amp;
     * @param integer $iEncType Default PHP_QUERY_RFC1738
     * @return string Returns a URL-encoded string.
     */
    public static function httpBuildQuery(array $aParams, $sNumericPrefix = null, $sArgSeparator = '&amp;', $iEncType = PHP_QUERY_RFC1738)
    {
        return http_build_query($aParams, $sNumericPrefix, $sArgSeparator, $iEncType);
    }

}