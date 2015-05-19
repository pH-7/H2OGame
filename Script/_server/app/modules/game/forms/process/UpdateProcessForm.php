<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class UpdateProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $oGameModel = new GameModel;

        $aData = [
            'game_id' => (int) $this->oHttpRequest->post('id'),
            'category_id' => (int) $this->oHttpRequest->post('category_id'),
            'name' => $this->oHttpRequest->post('name'),
            'title' => $this->oHttpRequest->post('title'),
            'description' => $this->oHttpRequest->post('description'),
            'keywords' => $this->oHttpRequest->post('keywords')
        ];

        if($oGameModel->exe($aData, 'update_game'))
        {
            // Success
            \PFBC\Form::clearValues('update_form');
            \PFBC\Form::setSuccess('update_form', trans('The game has been successfully updated'));
        }
        else
        {
            \PFBC\Form::setError('update_form', trans('Error occurred'));
        }
    }

}

