<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class RatingModel extends GameModel
{

    public function getVote($iId)
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_vote', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return (int) @$oRow->votes;
    }

    public function getScore($iId)
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_score', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iId, \PDO::PARAM_INT);
       $rStmt->execute();
       $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
       return (float) @$oRow->score;
    }

    public function updateVotes($iId)
    {
        $this->exe(array('game_id' => $iId), 'update_votes');
    }

    public function updateScore($iId, $fScore)
    {
        $this->exe(array('game_id' => $iId, 'score' => $fScore), 'update_score');
    }

}