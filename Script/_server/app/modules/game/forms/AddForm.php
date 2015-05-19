<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AddForm
{

    public static function display()
    {
        if (isset($_POST['submit_add']))
        {
            if (\PFBC\Form::isValid($_POST['submit_add']))
                new AddProcessForm;

            redirect('?m=game&c=admin&a=add');
        }

        $oGameModel = new GameModel;

        $oCategoriesData = $oGameModel->getCategories(null, 0, 500);
        $aCategoriesName = array();
        foreach ($oCategoriesData as $oId)
            $aCategoriesName[$oId->categoryId] = $oId->name;
        unset($oGameModel);

        $oForm = new \PFBC\Form('add_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_add', 'add_form'));
        $oForm->addElement(new \PFBC\Element\Select(trans('Category Name'), 'category_id', $aCategoriesName, array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Game Name'), 'name', array('validation' => new \PFBC\Validation\Str(2,120), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Game Title'), 'title', array('validation' => new \PFBC\Validation\Str(2,120), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textarea(trans('Description'), 'description', array('validation' => new \PFBC\Validation\Str(2,255), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Keywords'), 'keywords', array('validation' => new \PFBC\Validation\Str(2,255), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\File(trans('Game Thumbnail'), 'thumb', array('accept' => 'image/*', 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\File(trans('Game File'), 'file', array('accept' => 'application/x-shockwave-flash', 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Add a new Game')));
        $oForm->render();
    }

}