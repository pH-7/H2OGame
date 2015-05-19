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

        $this->oView->sTitle = trans('Admin Panel');
    }

    public function index()
    {
        $this->oView->sH2Title = trans('Welcome to your Admin Panel');
        $this->oView->sName = $this->oSession->get('admin_name');

        $this->display();
    }

    public function login()
    {
        $this->oView->sH2Title = trans('Login to your Admin Panel');

        $this->display();
    }

    public function account()
    {
        $this->oView->sH2Title = trans('Your Account');

        $this->display();
    }

    public function password()
    {
        $this->oView->sH2Title = trans('Change your Password');

        $this->display();
    }

    public function ads()
    {
        $this->oView->sH2Title = trans('Advertising');
        $this->oView->oAds = (new MainModel)->getAds();

        $this->display();
    }

    public function analytics()
    {
        $this->oView->sH2Title = trans('Analytics Code');

        $this->display();
    }

    public function logout()
    {
        Admin::logout($this->oSession);
    }

}
