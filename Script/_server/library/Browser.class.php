<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Browser
{

    /**
     * Active browser cache.
     * @return object this
     */
    public function cache()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600 * 24 * 30) . ' GMT');
        header('Pragma: public');
        //header ('Not Modified', true, 304);

        return $this;
    }

    /**
     * Prevent caching in the browser.
     *
     * @return object this
     */
    public function noCache()
    {
        $sNow = gmdate('D, d M Y H:i:s') . ' GMT';
        header('Expires: ' . $sNow);
        header('Last-Modified: ' . $sNow);
        unset($sNow);
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        return $this;
    }

}