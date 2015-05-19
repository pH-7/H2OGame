<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class EditProcessForm extends Controller
{

    public function __construct($iPageId)
    {
        parent::__construct();

        $aData = [
            'page_id' => $this->oHttpRequest->post('id'),
            'title' => $this->oHttpRequest->post('title'),
            'text' => $_POST['text'] // We don't use HttpRequest::post() because we want to allow HTML code in texts
        ];

        if ((new PageModel)->exe($aData, 'update_page'))
        {
            // OK
            \PFBC\Form::clearValues('edit_form' . $iPageId);
            \PFBC\Form::setSuccess('edit_form' . $iPageId, trans('The page has been successfully updated'));
        }
        else
        {
            \PFBC\Form::setError('edit_form' . $iPageId, trans('Error occurred'));
        }
    }

}

