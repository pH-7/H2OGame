<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class MainController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->oView->sTitle = trans('Installation');
    }

    public function index()
    {
        $this->oView->sH2Title = trans('Welcome to the Installer');

        $this->display();
    }

    public function config()
    {
         $this->oView->sH2Title = trans('Configuration');

        $this->display();
    }

    public function addAccount()
    {
        $this->oView->sH2Title = trans('Your Account');

        $this->display();
    }

    public function finish()
    {
        $this->oView->sH2Title = trans('Finish');

        $this->display();
    }

}
