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

    public function add()
    {
        $this->sTitle = trans('Add a Game');
        $this->oView->sTitle = $this->sTitle;

        $this->display();
    }

    public function update()
    {
        $this->sTitle = trans('Update the Game');
        $this->oView->sTitle = $this->sTitle;

        $this->display();
    }

    public function remove()
    {
        $iId = $this->oHttpRequest->post('id');

        if (!empty($iId) && is_numeric($iId))
        {
            // Get the game data
            $oData = $this->oGameModel->get($iId);

            // Delete the files
            $oFile = new File;
            $aFiles = [
                H2O_PUBLIC_DATA_PATH . 'game/file/' . $oData->file,
                H2O_PUBLIC_DATA_PATH . 'game/img/thumb/' . $oData->thumb
            ];
            $oFile->deleteFile($aFiles);
            unset($oFile);

            $this->oGameModel->delete($iId);
        }

         redirect('?m=game');
    }

}