<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AddAccountForm
{

    public static function display()
    {
        if (isset($_POST['submit_add_account']))
        {
            if (\PFBC\Form::isValid($_POST['submit_add_account']))
                new AddAccountProcessForm;

            redirect('?m=install&a=addaccount');
        }

        $oForm = new \PFBC\Form('add_account_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_add_account', 'add_account_form'));
        $oForm->addElement(new \PFBC\Element\Email(trans('Your email'), 'email', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Your name'), 'name', array('validation' => new \PFBC\Validation\Str(2,40), 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Password(trans('Your password'), 'password1', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Password(trans('Repeat your new Password'), 'password2', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Submit')));
        $oForm->render();
    }

}