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

    protected $oPageModel;

    public function __construct()
    {
        parent::__construct();
        $this->oPageModel = new PageModel;
    }

    public function index()
    {
        // Get the Name of the page
        switch ( $this->oHttpRequest->get('n') )
        {
            case 'privacy':
                $iId = 1;
            break;

            case 'about':
                $iId = 2;
            break;

            case 'contact':
                $iId = 3;
            break;

            default:
                redirect('?m=err');
        }

        $oData = $this->oPageModel->get($iId);
        $this->sTitle = $oData->title;
        $this->oView->sTitle = $this->sTitle;
        $this->oView->sH2Title = $this->sTitle;

        $this->oView->setAutoEscape(false); // Don't escape to allow the HTML code in pages
        $this->oView->sText = $oData->text;

        $this->display();
    }

}
