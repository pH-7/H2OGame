<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class ConfigForm
{

    public static function display()
    {
        if (isset($_POST['submit_config']))
        {
            if (\PFBC\Form::isValid($_POST['submit_config']))
                new ConfigProcessForm;

            redirect('?m=install&a=config');
        }

        $oForm = new \PFBC\Form('config_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_config', 'config_form'));

        $oForm->addElement(new \PFBC\Element\HTML('<h3>' . trans('Site Information') . '</h3>'));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Site Name'), 'site_name', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Site Slogan'), 'site_slogan', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Description of your site'), 'site_description', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Keywords of your site'), 'site_keywords', array('required' => 1)));

        $oForm->addElement(new \PFBC\Element\HTML('<h3>' . trans('Database Information') . '</h3>'));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Database Host Name'), 'db_host', array('value' => 'localhost', 'onfocus' => 'if ("localhost" == this.value) this.value="";', 'onblur' => 'if ("" == this.value) this.value = "localhost";', 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Database Name'), 'db_name', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Database User'), 'db_usr', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Password(trans('Database Password'), 'db_pwd', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Textbox(trans('Database Prefix'), 'db_prefix', array('value' => 'H2O_', 'onfocus' => 'if ("H2O_" == this.value) this.value="";', 'onblur' => 'if ("" == this.value) this.value = "H2O_";', 'required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Submit')));
        $oForm->render();
    }

}