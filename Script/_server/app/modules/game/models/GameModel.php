<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class GameModel extends Model
{

    protected $sQueryPath;

    public function __construct()
    {
        parent::__construct();
        $this->sQueryPath = __DIR__ . H2O_DS . 'queries/';
    }

    public function exe(array $aParams, $sSqlName)
    {
        return $this->exec($sSqlName, $this->sQueryPath, $aParams);
    }

    public function get($iId)
    {
        $iId = (int) $iId;

        $rStmt = $this->oDb->prepare( $this->getQuery('get_game', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        return $rStmt->fetch(\PDO::FETCH_OBJ);
    }

    public function gets($iOffset, $iLimit, $sOrderByColumn = SearchModel::TITLE)
    {
        $iOffset = (int) $iOffset;
        $iLimit = (int) $iLimit;

        $sSqlOrder = SearchModel::order($sOrderByColumn, SearchModel::DESC);
        $rStmt = $this->oDb->prepare('SELECT * FROM' . Db::prefix('Game') . $sSqlOrder . 'LIMIT :offset, :limit');
        $rStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
        $rStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
        $rStmt->execute();
        return $rStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCategories($iCategoryId = null, $iOffset, $iLimit, $bCount = false)
    {
        if($bCount)
        {
            $sSql = 'SELECT c.*, COUNT(g.gameId) AS totalCatGames FROM' . Db::prefix('GameCategory') . 'AS c INNER JOIN' . Db::prefix('Game') . 'AS g
                ON c.categoryId = g.categoryId GROUP BY c.name ASC LIMIT :offset, :limit';
        }
        else
        {
            $sSqlCategoryId = (!empty($iCategoryId)) ? ' WHERE categoryId = :categoryId ' : ' ';
            $sSql = 'SELECT * FROM' . Db::prefix('GameCategory') . $sSqlCategoryId . 'ORDER BY name ASC LIMIT :offset, :limit';
        }

        $rStmt = $this->oDb->prepare($sSql);

        if(!empty($iCategoryId)) $rStmt->bindValue(':categoryId', $iCategoryId, \PDO::PARAM_INT);
        $rStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
        $rStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
        $rStmt->execute();
        $oData = (!empty($iCategoryId)) ? $rStmt->fetch(\PDO::FETCH_OBJ) : $rStmt->fetchAll(\PDO::FETCH_OBJ);

        return $oData;
    }

    public function getFile($iGameId)
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_game_file', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iGameId, \PDO::PARAM_INT);
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return !empty($oRow->file) ? $oRow->file : '';
    }

    /**
     * Get View Statistics.
     *
     * @param integer $iId
     * @return integer Number of views.
     */
    public function getView($iId)
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_view_stat', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return (int) @$oRow->views;
    }

    /**
     * Get Download Statistics.
     *
     * @param integer $iId
     * @return integer The number of downloads
     */
    public function getDownloadStat($iId)
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_download_stat', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return (int) $oRow->downloads;
    }

    /**
     * Set Views Statistics.
     *
     * @param integer $iId
     * @return void
     */
    public function setView($iId)
    {
        $this->exe(array('game_id' => $iId), 'set_view_stat');
    }

    /**
     * Set Number Download Statistics.
     *
     * @param integer $iId
     * @return void
     */
    public function setDownloadStat($iId)
    {
        $this->exe(array('game_id' => $iId), 'set_download_stat');
    }

    public function delete($iId)
    {
        $iId = (int) $iId;

        $rStmt = $this->oDb->prepare( $this->getQuery('delete_game', $this->sQueryPath) );
        $rStmt->bindValue(':game_id', $iId, \PDO::PARAM_INT);
        return $rStmt->execute();
    }

    public function category($sCategoryName, $bCount, $sOrderByColumn, $sSort = SearchModel::ASC, $iOffset = null, $iLimit = null)
    {
        $bCount = (bool) $bCount;
        $iOffset = (int) $iOffset;
        $iLimit = (int) $iLimit;

        $sSqlOrder = SearchModel::order($sOrderByColumn, $sSort, 'n');
        $sSqlSelect = (!$bCount) ?  'g.*, c.*' : 'COUNT(g.gameId) AS totalGames';
        $sSqlLimit = (!$bCount) ? 'LIMIT :offset, :limit' : '';

        $rStmt = $this->oDb->prepare('SELECT ' . $sSqlSelect . ' FROM' . Db::prefix('Game') . 'AS g LEFT JOIN ' . Db::prefix('GameCategory') . 'AS c ON g.categoryId = c.categoryId
        WHERE c.name LIKE :name' . $sSqlOrder . $sSqlLimit);

        $rStmt->bindValue(':name', '%' . $sCategoryName . '%', \PDO::PARAM_STR);

        if(!$bCount)
        {
            $rStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $rStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
        }

        $rStmt->execute();

        if(!$bCount)
        {
            $mData = $rStmt->fetchAll(\PDO::FETCH_OBJ);
        }
        else
        {
            $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
            $mData = (int) $oRow->totalGames;
            unset($oRow);
        }

        return $mData;
    }

    /**
     * Search a Game.
     *
     * @param mixed (integer for game ID or string for a keyword) $mLooking
     * @param boolean $bCount Put 'true' for count the games or 'false' for the result of games.
     * @param string $sOrderByColumn
     * @param string $sSort Default: \H2O\SearchModel::ASC
     * @param integer $iOffset Default: NULL
     * @param integer $iLimit Default: NULL
     * @return mixed (integer for the number games returned or string for the games list returned)
     */
    public function search($mLooking, $bCount, $sOrderByColumn, $sSort = SearchModel::ASC, $iOffset = null, $iLimit = null)
    {
        $bCount = (bool) $bCount;
        $iOffset = (int) $iOffset;
        $iLimit = (int) $iLimit;

        $sSqlOrder = SearchModel::order($sOrderByColumn, $sSort);
        $sSqlSelect = (!$bCount) ?  '*' : 'COUNT(gameId) AS totalGames';
        $sSqlWhere = (ctype_digit($mLooking)) ? ' WHERE gameId = :looking' : ' WHERE title LIKE :looking OR name LIKE :looking OR description LIKE :looking OR keywords LIKE :looking';
        $sSqlLimit = (!$bCount) ? 'LIMIT :offset, :limit' : '';

        $rStmt = $this->oDb->prepare('SELECT ' . $sSqlSelect . ' FROM' . Db::prefix('Game') . $sSqlWhere . $sSqlOrder . $sSqlLimit);

        (ctype_digit($mLooking)) ? $rStmt->bindValue(':looking', $mLooking, \PDO::PARAM_INT) : $rStmt->bindValue(':looking', '%' . $mLooking . '%', \PDO::PARAM_STR);

        if(!$bCount)
        {
            $rStmt->bindParam(':offset', $iOffset, \PDO::PARAM_INT);
            $rStmt->bindParam(':limit', $iLimit, \PDO::PARAM_INT);
        }

        $rStmt->execute();

        if(!$bCount)
        {
            $mData = $rStmt->fetchAll(\PDO::FETCH_OBJ);
        }
        else
        {
            $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
            $mData = (int) $oRow->totalGames;
            unset($oRow);
        }

        return $mData;
    }

    public function countGames()
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('count_games', $this->sQueryPath) );
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return (int) $oRow->totalGames;
    }

    public function isGameInstalled()
    {
        return ($this->countGames() > 0);
    }

}