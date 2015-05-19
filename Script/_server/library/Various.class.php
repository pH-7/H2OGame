<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Various
{

    /**
     * Generate Random.
     *
     * @static
     * @param string $sStr
     * @param integer $iLength Default is 40 Characters.
     * @return string
     */
    public static function genRnd($sStr = null, $iLength = 40)
    {
        $sStr = (!empty($sStr)) ? (string) $sStr : '';
        $sChars = hash('whirlpool', hash('whirlpool', uniqid(mt_rand(), true) . $sStr . client_ip() . time()) . hash('sha512', user_agent() . microtime(true)*9999));
        return self::padStr($sChars, $iLength);
    }

    /**
     * Padding String.
     *
     * @static
     * @param string $sStr
     * @param integer $iLength
     * @return string
     */
    public static function padStr($sStr, $iLength = 40)
    {
        $iLength = (int) $iLength;
        return (mb_strlen($sStr) >= $iLength) ? substr($sStr, 0, $iLength) : str_pad($sStr, $iLength, $sStr);
    }

}