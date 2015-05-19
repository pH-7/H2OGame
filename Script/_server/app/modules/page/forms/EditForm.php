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

    public static function display($oPage)
    {
        if (isset($_POST['submit_edit' . $oPage->pageId]))
        {
            if (\PFBC\Form::isValid($_POST['submit_edit' . $oPage->pageId]))
                new EditProcessForm($oPage->pageId);

            redirect('?m=page&c=admin');
        }

        $oForm = new \PFBC\Form('edit_form' . $oPage->pageId);
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_edit' . $oPage->pageId, 'edit_form' . $oPage->pageId));
        $oForm->addElement(new \PFBC\Element\Hidden('id', $oPage->pageId));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Title'), 'title', array('value' => $oPage->title, 'style' => 'width:350px', 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textarea(trans('Text'), 'text', array('value' => $oPage->text, 'style' => 'width:350px', 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Update')));
        $oForm->render();
    }

}