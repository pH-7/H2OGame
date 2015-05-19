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

    protected $oGameModel, $oPage;

    public function __construct()
    {
        parent::__construct();

        $this->oGameModel = new GameModel;
        $this->oPage = new Page;
    }

    public function index()
    {
        $this->iTotalGames = $this->oGameModel->search($this->oHttpRequest->get('looking'), true, $this->oHttpRequest->get('order'), $this->oHttpRequest->get('sort'));

        $this->oView->iTotalPages = $this->oPage->getTotalPages($this->iTotalGames, 10);
        $this->oView->iCurrentPage = $this->oPage->getCurrentPage();

        $oSearch = $this->oGameModel->search($this->oHttpRequest->get('looking'), false, $this->oHttpRequest->get('order'), $this->oHttpRequest->get('sort'), $this->oPage->getFirstItem(), $this->oPage->getNbItemsByPage());

        $this->sTitle = trans('Welcome');
        $this->oView->sTitle = $this->sTitle;

        if (empty($oSearch))
        {
            $this->oView->sErrMsg = trans('There are currently no games installed. Please install some before to continue');
        }
        else
        {
            $this->oView->sH2Title = $this->sTitle;
            $this->oView->sKeywords = trans('keywords_data');

            $this->setMenuVars();
            $this->oView->oGames = $oSearch;

        }

        $this->display();
    }

    public function game()
    {
        $oGame = $this->oGameModel->get( $this->oHttpRequest->get('id') );

        if (!empty($oGame) && is_file(H2O_PUBLIC_DATA_PATH . 'game/file/' . $oGame->file))
        {
            $this->sTitle = $oGame->title;

            $this->oView->sTitle = $this->sTitle;
            $this->oView->sH2Title = $this->sTitle;
            $this->oView->sDescription = trans('Game') . $oGame->description;
             $this->oView->sKeywords = $oGame->keywords;
            $this->oView->iId = $oGame->gameId;
            $this->oView->sStats = $this->oGameModel->getView($oGame->gameId);
            $this->oView->sDownloads = $this->oGameModel->getDownloadStat($oGame->gameId);
            $this->oView->sName = $oGame->name;
            $this->oView->sFullFile = H2O_PUBLIC_DATA_URL . 'game/file/' . $oGame->file;

            /** Display HTML content **/
            $this->oView->setAutoEscape(false); // Don't escape to allow the HTML code
            $this->oView->sVotes = $this->getDesignVotes($oGame->gameId, 'center');

            // Increment Statistics
            $this->oGameModel->setView($oGame->gameId);
        }
        else
        {
            redirect('?m=err'); // The "err" module doesn't exist. So it'll displays the "Not Found" page.
        }

        $this->display();
    }

    public function category()
    {
        $sCategory = str_replace('-', ' ', $this->oHttpRequest->get('name'));
        $sOrder = $this->oHttpRequest->get('order');
        $sSort = $this->oHttpRequest->get('sort');

        $this->iTotalGames = $this->oGameModel->category($sCategory, true, $sOrder, $sSort, null, null);
        $this->oView->iTotalPages = $this->oPage->getTotalPages($this->iTotalGames, 10);
        $this->oView->iCurrentPage = $this->oPage->getCurrentPage();

        $oSearch = $this->oGameModel->category($sCategory, false, $sOrder, $sSort, $this->oPage->getFirstItem(), $this->oPage->getNbItemsByPage());
        $this->setMenuVars();

        if (empty($oSearch))
        {
            redirect('?m=err'); // The "err" module doesn't exist. So it'll displays the "Not Found" page
        }
        else
        {
            $sCategoryTxt = substr($sCategory,0,60);

            $this->sTitle = trans('Search by Category: "%0%" Game', $sCategoryTxt);
            $this->oView->sTitle = $this->sTitle;
            $this->oView->sH2Title = $this->sTitle;
            $this->oView->sDescription = trans('Search a Game in %0% Category', $sCategoryTxt);

            $this->oView->oGames = $oSearch;
        }

        $this->display();
    }

    public function search()
    {
        $this->sTitle = trans('Search a Game');
        $this->oView->sH2Title = $this->sTitle;
        $this->oView->sH2Title = $this->sTitle;

        $this->display();
    }

    public function download()
    {
        $iId = $this->oHttpRequest->get('id');

        if (!empty($iId) && is_numeric($iId))
        {
            $sFile = @$this->oGameModel->getFile($iId);
            $sPathFile = H2O_PUBLIC_DATA_PATH . 'game/file/' . $sFile;

            if (!empty($sFile) && is_file($sPathFile))
            {
                $sFileName = basename($sFile);
                (new File)->download($sPathFile, $sFileName);
                $this->oGameModel->setDownloadStat($iId);
                exit(0);
            }
        }

        redirect('?m=err'); // The "err" module doesn't exist. So it'll displays the "Not Found" page.
    }

    /**
     * Generates design the voting system.
     *
     * @param integer $iId ID of the game
     * @param string $sCssClass Default value is empty. You can add the name of a CSS class (attention, only its name) e.g. 'center'.
     * @return string The HTML Vote data
    */
    protected function getDesignVotes($iId, $sCssClass = '')
    {
        $oRatingModel = new RatingModel;
        $iVotes = $oRatingModel->getVote($iId);
        $fScore = $oRatingModel->getScore($iId);
        unset($oRatingModel);

        $fRate = ($iVotes > 0) ? number_format($fScore/$iVotes, 1) : 0;

        $sPHSClass = 'pHS' . $iId;

        $sRet = '<script src="' . H2O_ROOT_URL . 'static/js/jquery/rating.js"></script>';
        $sRet .= '<div class="' . $sCssClass . ' ' . $sPHSClass . '" id="' . $fRate . '_' . $iId . '"></div><p class="' . $sPHSClass . '_txt">' . trans('Score: %0% - Votes: %1%', $fRate, $iVotes) . '<br /><br /></p><script>$(".' . $sPHSClass . '").pHRating({length:5,decimalLength:1,rateMax:5});</script>';

        return $sRet;
    }

    /**
     * Sets the Menu Variables for the template.
     *
     * @access protected
     * @return void
     */
    protected function setMenuVars()
    {
        $this->oView->oTopViews = $this->oGameModel->gets(0, 5, SearchModel::VIEWS);
        $this->oView->oTopRating = $this->oGameModel->gets(0, 5, SearchModel::RATING);
        $this->oView->oLatest = $this->oGameModel->gets(0, 5, SearchModel::ADDED_DATE);
        $this->oView->oCategories = $this->oGameModel->getCategories(null, 0, 50, true);
    }

}
