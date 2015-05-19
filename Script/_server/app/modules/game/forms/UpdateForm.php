<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class UpdateForm
{

    public static function display()
    {
        $oGameModel = new GameModel;
        $oHttpRequest = new HttpRequest;

        $iGameId = (int) $oHttpRequest->get('id');
        $oGame = $oGameModel->get($iGameId);
        if (empty($oGame))
            exit(trans('Unable to load data! Please check that the reading ID is correct'));

        if (isset($_POST['submit_update']))
        {
            if (\PFBC\Form::isValid($_POST['submit_update']))
                new UpdateProcessForm;

            redirect('?m=game&c=admin&a=update&id=' . $iGameId);
        }

        $oCategoriesData = $oGameModel->getCategories(null, 0, 500);
        $aCategoriesName = array();
        foreach ($oCategoriesData as $oId)
            $aCategoriesName[$oId->categoryId] = $oId->name;
        unset($oHttpRequest, $oGameModel);

        $oForm = new \PFBC\Form('update_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_update', 'update_form'));
        $oForm->addElement(new \PFBC\Element\Hidden('id', $iGameId));
        $oForm->addElement(new \PFBC\Element\Select(trans('Category Name'), 'category_id', $aCategoriesName, array('value' => $oGame->categoryId, 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Game Name'), 'name', array('value' => $oGame->name, 'validation' => new \PFBC\Validation\Str(2,120), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Game Title'), 'title', array('value' => $oGame->title, 'validation' => new \PFBC\Validation\Str(2,120), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textarea(trans('Description'), 'description', array('value' => $oGame->description, 'validation' => new \PFBC\Validation\Str(2,255), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Keywords'), 'keywords', array('value' => $oGame->keywords, 'validation' => new \PFBC\Validation\Str(2,255), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Update the Game')));
        $oForm->render();
    }

}
