<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AdminController extends MainController
{

    public function index()
    {
        $this->sTitle = trans('Edit Pages');
        $this->oView->sTitle = $this->sTitle;
        $this->oView->sH2Title = $this->sTitle;

        $this->oView->oPages = $this->oPageModel->gets();

        $this->display();
    }

}
