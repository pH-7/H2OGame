<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AddProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $oGameModel = new GameModel;
        $oFile = new File;

        // Thumbnail
        $oImg = new Image($_FILES['thumb']['tmp_name']);
        if (!$oImg->validate())
        {
            \PFBC\Form::setError('add_form', trans('Wrong Image Format'));
            return; // Stop execution of the method.
        }

        $sThumbFile = Various::genRnd($oImg->getFileName(), 30) . $oImg->getExt();
        $sThumbDir = H2O_PUBLIC_DATA_PATH. 'game/img/thumb/';

        $oImg->square(60);
        $oImg->save($sThumbDir . $sThumbFile);
        unset($oImg);

        // Game
        $sGameFile = Various::genRnd($_FILES['file']['name'], 30) . H2O_DOT . $oFile->getFileExt($_FILES['file']['name']);
        $sGameDir =  H2O_PUBLIC_DATA_PATH . 'game/file/';

        // If the folders is not created (games not installed), yet we will create.
        $oFile->createDir( array($sThumbDir, $sGameDir) );

        if (!@move_uploaded_file($_FILES['file']['tmp_name'], $sGameDir . $sGameFile))
        {
            \PFBC\Form::setError('add_form', trans('Impossible to upload the game. Please check if the folder %0% has write permission', '"' . $sGameDir . $sGameFile . '"'));
        }
        else
        {
            $aData = [
                'category_id' => (int) $this->oHttpRequest->post('category_id'),
                'name' => $this->oHttpRequest->post('name'),
                'title' => $this->oHttpRequest->post('title'),
                'description' => $this->oHttpRequest->post('description'),
                'keywords' => $this->oHttpRequest->post('keywords'),
                'thumb' => $sThumbFile,
                'file' => $sGameFile
            ];

            if($oGameModel->exe($aData, 'add_game'))
            {
                // Success
                \PFBC\Form::clearValues('add_form');
                \PFBC\Form::setSuccess('add_form', trans('The game has been successfully added'));
           }
            else
            {
                \PFBC\Form::setError('add_form', trans('Error occurred'));
            }
        }
    }

}

