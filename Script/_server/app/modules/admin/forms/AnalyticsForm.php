<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AnalyticsForm
{

    public static function display()
    {
        if (isset($_POST['submit_analytics']))
        {
            if (\PFBC\Form::isValid($_POST['submit_analytics']))
                new AnalyticsProcessForm;

            redirect('?m=admin&a=analytics');
        }

        $oForm = new \PFBC\Form('analytics_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_analytics', 'analytics_form'));
        $oForm->addElement(new \PFBC\Element\Textarea(trans('Your Analytics Code'), 'code', array('value' => (new MainModel)->getAnalytics(), 'style' => 'width:350px')));
        $oForm->addElement(new \PFBC\Element\Button(trans('Save')));
        $oForm->render();
    }

}
