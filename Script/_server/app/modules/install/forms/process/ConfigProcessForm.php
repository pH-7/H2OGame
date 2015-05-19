<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class ConfigProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        try
        {
            $sFullConfigPath = H2O_SERVER_PATH . 'library/Config.class.php';
            @chmod($sFullConfigPath, 0666);
            $sConfigContent = file_get_contents($sFullConfigPath);

            $aReplace = [
                "SITE_NAME = ''" => "SITE_NAME = '" . addslashes($this->oHttpRequest->post('site_name')) . "'",
                "SITE_SLOGAN = ''" => "SITE_SLOGAN = '" . addslashes($this->oHttpRequest->post('site_slogan')) . "'",
                "SITE_DESCRIPTION = ''" => "SITE_DESCRIPTION = '" . addslashes($this->oHttpRequest->post('site_description')) . "'",
                "SITE_KEYWORDS = ''" => "SITE_KEYWORDS = '" . addslashes($this->oHttpRequest->post('site_keywords')) . "'",
                "DB_HOST = ''" => "DB_HOST = '" . $this->oHttpRequest->post('db_host') . "'",
                "DB_NAME = ''" => "DB_NAME = '" . $this->oHttpRequest->post('db_name') . "'",
                "DB_USR = ''" => "DB_USR = '" . $this->oHttpRequest->post('db_usr') . "'",
                "DB_PWD = ''" => "DB_PWD = '" . $this->oHttpRequest->post('db_pwd') . "'",
                "DB_TABLE_PREFIX = ''" => "DB_TABLE_PREFIX = '" . $this->oHttpRequest->post('db_prefix') . "'"
            ];

            $sConfigContent = str_replace_assoc($aReplace, $sConfigContent);

            if (!@file_put_contents($sFullConfigPath, $sConfigContent))
            {
                \PFBC\Form::setError('config_form', trans('Please change the permission for the %0% file in write mode', '"' . $sFullConfigPath . '"'));
            }
            else
            {
                @chmod($sFullConfigPath, 0644);
                $oDb = $this->_dbConnect();

                if (!($oDb->getAttribute(\PDO::ATTR_DRIVER_NAME) == 'mysql' && version_compare($oDb->getAttribute(\PDO::ATTR_SERVER_VERSION), H2O_REQUIRE_SQL_VERSION, '>=')))
                {
                    \PFBC\Form::setError('config_form', trans('Oops! Your MySQL version is %0%. Please install MySQL %1% or higher in order to continue.', $oDb->getAttribute(\PDO::ATTR_SERVER_VERSION), PH7_REQUIRE_SQL_VERSION));
                }
                else
                {
                    exec_query_file($oDb, H2O_SERVER_PATH . 'app/modules/install/data/sql/' . Config::DB_TYPE_NAME . '/core.sql', $this->oHttpRequest->post('db_prefix'));

                    // All is okay, so we can clear the session data
                    \PFBC\Form::clearValues('config_form');

                    redirect('?m=install&a=addaccount');
                }
            }
        }
        catch (\PDOException $oE)
        {
            \PFBC\Form::setError('config_form', trans('Error connecting to your database. %0%', escape($oE->getMessage())));
        }
    }

    private function _dbConnect()
    {
        $aParams = array
        (
            'db_type' => Config::DB_TYPE,
            'db_host' => $this->oHttpRequest->post('db_host'),
            'db_name' => $this->oHttpRequest->post('db_name'),
            'db_usr' => $this->oHttpRequest->post('db_usr'),
            'db_pwd' => $this->oHttpRequest->post('db_pwd'),
            'db_charset' => Config::DB_CHARSET
        );

        return new Db($aParams);
    }

}