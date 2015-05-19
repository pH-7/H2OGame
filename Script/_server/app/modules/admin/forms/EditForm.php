<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class EditForm
{

    public static function display()
    {
        if (isset($_POST['submit_edit']))
        {
            if (\PFBC\Form::isValid($_POST['submit_edit']))
                new EditProcessForm;

            redirect('?m=admin&a=account');
        }

        $oData = (new AdminModel)->readProfile((new Session)->get('admin_id'));
        if (empty($oData))
            exit(trans('Unable to load data! Please check that the reading ID is correct'));

        $oForm = new \PFBC\Form('edit_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_edit', 'edit_form'));
        $oForm->addElement(new \PFBC\Element\Email(trans('Email'), 'email', array('value' => $oData->email, 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Name'), 'name', array('validation' => new \PFBC\Validation\Str(2,40), 'value' => $oData->name, 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Select(trans('Language preference'), 'lang', Main::getLangList(), array('value' => $oData->lang, 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Update')));
        $oForm->render();
    }

}