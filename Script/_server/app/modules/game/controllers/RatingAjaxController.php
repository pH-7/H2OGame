<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class RatingAjaxController extends Controller
{

    private $_oRatingModel, $_sTxt, $_iStatus, $_iId, $_fScore;
    private static $_iVotes;

    public function __construct()
    {
        parent::__construct();

        $sAction = $this->oHttpRequest->post('action');
        $this->_fScore = (float) $this->oHttpRequest->post('score');
        $this->_iId = (int) $this->oHttpRequest->post('id');

        if (!empty($sAction) && !empty($this->_fScore) && !empty($this->_iId))
        {
            if($sAction == 'rating')
                $this->initialize();
        }
        else
        {
            header('HTTP/1.1 401 Unauthorized');
            exit('Bad Request Error!');
        }
    }

    /**
     * Displays the votes.
     *
     * @access public
     * @return string
     */
    public function show()
    {
        echo json_msg($this->_iStatus, $this->_sTxt);
    }

    /**
     * Initialize the methods of the class.
     *
     * @access protected
     * @return void
     */
    protected function initialize()
    {
        $this->_oRatingModel = new RatingModel;

        /**
         * @internal Today's IP address is also easier to change than delete a cookie, so we have chosen the Cookie instead save the IP address in the database.
         */
        $oCookie = new Cookie;
        $sCookieName = 'pHSVoting' . $this->_iId;

        if($oCookie->exists($sCookieName))
        {
            $this->_iStatus = 0;
            $this->_sTxt = trans('You have already voted');
            return;
        }
        else
        {
            $oCookie->set($sCookieName, 1, 3600*24*7); // A week
        }
        unset($oCookie);

        $this->select();
        $this->update();
        $this->_iStatus = 1;
        $sVoteTxt = (static::$_iVotes > 1) ? trans('Votes') : trans('Vote');
        $this->_sTxt = trans('Score: %0% - %2%: %1%', number_format($this->_fScore/static::$_iVotes, 1), static::$_iVotes, $sVoteTxt);
    }

    /**
     * Adds voting in the database and increment the static attribute to vote.
     *
     * @access protected
     * @return void
     */
    protected function select()
    {
        $iVotes = $this->_oRatingModel->getVote($this->_iId);
        $fRate = $this->_oRatingModel->getScore($this->_iId);

        static::$_iVotes = $iVotes+=1;
        $fScore = (float) $this->oHttpRequest->post('score');

        $this->_fScore = $fRate+=$fScore;
    }

    /**
     * Updates the vote in the database.
     *
     * @access protected
     * @return void
     */
    protected function update()
    {
        $this->_oRatingModel->updateVotes($this->_iId);
        $this->_oRatingModel->updateScore($this->_iId, $this->_fScore);
    }

}