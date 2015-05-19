<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class File
{

    // End Of Line relative to the operating system
    const EOL = PHP_EOL;

    /**
     * Mime Types list.
     *
     * @access private
     * @staticvar array $_aMimeTypes
     */
    private static $_aMimeTypes = [
        'pdf' => 'application/pdf',
        'txt' => 'text/plain',
        'html' => 'text/html',
        'htm' => 'text/html',
        'exe' => 'application/octet-stream',
        'zip' => 'application/zip',
        'doc' => 'application/msword',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'jpeg' => 'image/jpg',
        'jpg' => 'image/jpg',
        'ico' => 'image/x-icon',
        'eot' => 'application/vnd.ms-fontobject',
        'otf' => 'application/octet-stream',
        'ttf' => 'application/octet-stream',
        'woff' => 'application/octet-stream',
        'svg' => 'application/octet-stream',
        'swf' => 'application/x-shockwave-flash',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
        'mov' => 'video/quicktime',
        'avi' => 'video/x-msvideo',
        'php' => 'text/plain',
    ];

    /**
     * Get Mime Type.
     *
     * @param string $sExt Extension File.
     * @return string (string | null) Returns the "mime type" if it is found, otherwise "null"
     */
    public function getMimeType($sExt)
    {
        return (array_key_exists($sExt, static::$_aMimeTypes)) ? static::$_aMimeTypes[$sExt] : null;
    }

    /**
     * Get Extension file without the dot.
     *
     * @param string $sFile The File Name.
     * @return string
     */
    public function getFileExt($sFile)
    {
        return strtolower(substr(strrchr($sFile, H2O_DOT), 1));
    }

    /**
     * Get File without Extension and dot.
     * This function is smarter than just a code like this, substr($sFile,0,strpos($sFile,'.'))
     * Just look at the example below for you to realize that the function removes only the extension and nothing else!
     * Example 1 "my_file.pl" The return value is "my_file"
     * Example 2 "my_file.inc.pl" The return value is "my_file.inc"
     * Example 3 "my_file.class.html.php" The return value is "my_file.class.html"
     *
     * @see \H2O\File::getFileExt() To see the method that retrieves the file extension.
     * @param string $sFile
     * @return string
     */
    public function getFileWithoutExt($sFile)
    {
        $sExt = $this->getFileExt($sFile);
        return str_replace(H2O_DOT . $sExt, '', $sFile);
    }

 /**
     * Creates a directory if they are in an array. If it does not exist and
     * allows the creation of nested directories specified in the pathname.
     *
     * @param mixed (string | array) $mDir
     * @param integer (octal) $iMode Default: 0777
     * @return void
     * @throws \Exception If the file cannot be created.
     */
    public function createDir($mDir, $iMode = 0777)
    {
        if (is_array($mDir))
        {
            foreach ($mDir as $sD) $this->createDir($sD);
        }
        else
        {
            if (!is_dir($mDir))
                if (!@mkdir($mDir, $iMode, true))
                    throw new \Exception('Error to create file: \'' . $mDir . '\'<br /> Please verify that the directory permission is in writing mode.');
        }
    }

    /**
     * Copies files and checks if the "from file" exists.
     *
     * @param string $sFrom File.
     * @param string $sTo File.
     * @return boolean
     */
    public function copy($sFrom, $sTo)
    {
        if (!is_file($sFrom)) return false;

        return @copy($sFrom, $sTo);
    }

    /**
     * Copy the contents of a directory into another.
     *
     * @param string $sFrom Old directory.
     * @param string $sTo New directory.
     * @return boolean Returns true if everything went well except if the file / directory from does not exist or if the copy went wrong.
     */
    public function copyDir($sFrom, $sTo)
    {
        return $this->_recursiveDirIterator($sFrom, $sTo, 'copy');
    }

    /**
     * Renames a file or directory and checks if the "from file" or directory exists with file_exists() function
     * since it checks the existance of a file or directory (because, as in the Unix OS, a directory is a file).
     *
     * @param string $sFrom File or directory.
     * @param string $sTo File or directory.
     * @return boolean
     */
    public function rename($sFrom, $sTo)
    {
        if (!file_exists($sFrom)) return false;

        return @rename($sFrom, $sTo);
    }

    /**
     * Renames the contents of a directory into another.
     *
     * @param string $sFrom Old directory.
     * @param string $sTo New directory.
     * @return boolean Returns true if everything went well except if the file / directory from does not exist or if the copy went wrong.
     */
    public function renameDir($sFrom, $sTo)
    {
        return $this->_recursiveDirIterator($sFrom, $sTo, 'rename');
    }

    /**
     * Deletes a file or files if they are in an array.
     * If the file does not exist, the function does nothing.
     *
     * @param mixed (string | array) $mFile
     * @return void
     */
    public function deleteFile($mFile)
    {
        if (is_array($mFile))
            foreach ($mFile as $sF) $this->deleteFile($sF);
        else
            if (is_file($mFile)) unlink($mFile);
    }

    /**
     * For deleting Directory and files!
     * A "rmdir" function improved PHP which also delete files in a directory.
     *
     * @param string $sPath The path
     * @return boolean
     */
    public function deleteDir($sPath)
    {
        return (is_file($sPath) ? unlink($sPath) : (is_dir($sPath) ? array_map(array($this, 'deleteDir'), glob($sPath . '/*')) === @rmdir($sPath) : false));
    }

    /**
     * Remove the contents of a directory.
     *
     * @param string $sDir
     * @return void
     */
    public function remove($sDir)
    {
        $oIterator = new \RecursiveIteratorIterator($this->getDirIterator($sDir), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($oIterator as $sPath) ($sPath->isFile()) ? unlink($sPath) : @rmdir($sPath);
        @rmdir($sDir);
    }

    /**
     * Get file size.
     *
     * @param string $sFile
     * @return integer The size of the file in bytes.
     */
    public function size($sFile)
    {
        return filesize($sFile);
    }

    /**
     * @param string File Name.
     * @return mixed (integer | boolean) Returns the "time the file was last modified", or "false" if it not found.
     */
    public function modificationTime($sFile)
    {
        return (is_file($sFile)) ? filemtime($sFile) : false;
    }

    /**
     * For download file.
     *
     * @param string $sFile file in download.
     * @param string $sName if file in download.
     * @param string $sMimeType Optional, default value is NULL.
     * @return void
     */
    public function download($sFile, $sName, $sMimeType = null)
    {
        /*
          This function takes a path to a file to output ($sFile),
          the filename that the browser will see ($sName) and
          the MIME type of the file ($sMimeType, optional).

          If you want to do something on download abort/finish,
          register_shutdown_function('function_name');
         */

        //if (!is_readable($sFile)) exit('File not found or inaccessible!');

        $sName = Url::decode($sName); // Clean the name file

        /* Figure out the MIME type (if not specified) */


        if (empty($sMimeType))
        {
            $sFileExtension = $this->getFileExt($sFile);

            $mGetMimeType = $this->getMimeType($sFileExtension);

            if (!empty($mGetMimeType))
                $sMimeType = $mGetMimeType;
            else
                $sMimeType = 'application/force-download';
        }

        @ob_end_clean(); // Turn off output buffering to decrease CPU usage

        (new Browser)->nocache(); // No cache

        $sPrefix = Config::SITE_NAME . '_'; // the prefix
        header('Content-Type: ' . $sMimeType);
        header('Content-Disposition: attachment; filename=' . Url::parseClean($sPrefix) . $sName);
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . $this->size($sFile));
        readfile($sFile);
    }

    /**
     * Writes and saves the contents to a file.
     * It also creates a temporary file does not delete the original file if something goes wrong during the recording file.
     *
     * @param string $sFile
     * @param string $sData
     * @return integer Returns the number of bytes written, or NULL on error.
     */
    public function save($sFile, $sData)
    {
        $sTmpFile = $this->getFileWithoutExt($sFile) . '.tmp.' . $this->getFileExt($sFile);
        $iWritten = (new \SplFileObject($sTmpFile, 'wb'))->fwrite($sData);

        if ($iWritten != null) {
            // Copy of the temporary file to the original file if no problem occurred.
            copy($sTmpFile, $sFile);
        }

        // Deletes the temporary file.
        $this->deleteFile($sTmpFile);

        return $iWritten;
    }

    /**
     * Reading Files.
     *
     * @param string $sPath
     * @param mixed (array | string) $mFiles
     * @return mixed (array | string) The Files.
     */
    public function readFiles($sPath = './', &$mFiles)
    {
        if (!($rHandle = opendir($sPath))) return false;

        while (false !== ($sFile = readdir($rHandle)))
        {
            if ($sFile != '.' && $sFile != '..')
            {
                if (strpos($sFile, '.') === false)
                    $this->readFiles($sPath . H2O_DS . $sFile, $mFiles);
                else
                    $mFiles[] = $sPath . H2O_DS . $sFile;
            }
        }
        closedir($rHandle);
        return $mFiles;
    }

    /**
     * Reading Directories.
     *
     * @param string $sPath
     * @return mixed (array | boolean) Returns an array with the folders or false if the folder could not be opened.
     */
    public function readDirs($sPath = './')
    {
        if (!($rHandle = opendir($sPath))) return false;
        $aRet = array();//remove it for yield

        while (false !== ($sFolder = readdir($rHandle)))
        {
            if ('.' == $sFolder || '..' == $sFolder || !is_dir($sPath . $sFolder))
                continue;
            //yield $sFolder; // PHP 5.5
            $aRet[] = $sFolder;//remove it for yield
        }
        closedir($rHandle);
        return $aRet;//remove it for yield
    }

    /**
     * @param string $sDir The directory.
     * @return array The list of the folder that is in the directory.
     */
    public function getDirList($sDir)
    {
        $aDirList = array();

        if ($rHandle = opendir($sDir))
        {
            while (false !== ($sFile = readdir($rHandle)))
            {
                if ($sFile != '.' && $sFile != '..' && is_dir($sDir . H2O_DS . $sFile))
                    $aDirList[] = $sFile;
            }
            asort($aDirList);
            reset($aDirList);
        }
        closedir($rHandle);
        return $aDirList;
    }


    /**
     * @param string $sDir
     * @param mixed (string | array) $mExt Optional, retrieves only files with specific extensions. Default value is NULL.
     * @return array List of files sorted alphabetically.
     */
    public function getFileList($sDir, $mExt = null)
    {
        $aTree = array();
        $sDir = $this->checkExtDir($sDir);

        if (is_dir($sDir) && $rHandle = opendir($sDir))
        {
            while (false !== ($sF = readdir($rHandle)))
            {
                if ($sF != '.' && $sF != '..')
                {
                    if (is_dir($sDir . $sF))
                    {
                        $aTree = array_merge($aTree, $this->getFileList($sDir . $sF));
                    }
                    else
                    {
                        if (!empty($mExt))
                        {
                            $aExt = (array) $mExt;

                            foreach ($aExt as $sExt)
                            {
                                if (substr($sF, -strlen($sExt)) === $sExt)
                                    $aTree[] = $sDir . $sF;
                            }
                        }
                        else
                        {
                            $aTree[] = $sDir . $sF;
                        }
                    }
                }
            }
            sort($aTree);
        }
        closedir($rHandle);
        return $aTree;
    }

    /**
     * Make sure that folder names have a trailing.
     *
     * @param string $sDir The directory.
     * @param bool $bStart for check extension directory start. Default FALSE
     * @param bool $bEnd for check extension end. Default TRUE
     * @return string $sDir Directory
     */
    public function checkExtDir($sDir, $bStart = false, $bEnd = true)
    {
        if (!is_windows() && $bStart === true && substr($sDir, 0, 1) !== H2O_DS)
            $sDir = H2O_DS . $sDir;

        if ($bEnd === true && substr($sDir, -1) !== H2O_DS)
            $sDir .= H2O_DS;

        return $sDir;
    }

    /**
     * Get the URL contents (For URLs, it is better to use CURL because it is faster than file_get_contents function).
     *
     * @param string $sFile URL to be read contents.
     * @return mixed (string | boolean) Return the result content on success, FALSE on failure.
     */
    public function getUrlContents($sFile)
    {
        $rCh = curl_init();
        curl_setopt($rCh, CURLOPT_URL, $sFile);
        curl_setopt($rCh, CURLOPT_HEADER, 0);
        curl_setopt($rCh, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rCh, CURLOPT_FOLLOWLOCATION, 1);
        $mRes = curl_exec($rCh);
        curl_close($rCh);
        unset($rCh);

        return $mRes;
    }

    /**
     * Create a recurive directory iterator for a given directory.
     *
     * @param string $sPath
     * @return string The directory.
     */
    public function getDirIterator($sPath)
    {
        return (new \RecursiveDirectoryIterator($sPath));
    }

    /**
     * Recursive Directory Iterator.
     *
     * @access private
     * @param string $sFuncName The function name. Choose between 'copy' and 'rename'.
     * @param string $sFrom Directory.
     * @param string $sTo Directory.
     * @return boolean
     * @throws \Exception If the type is bad.
     */
    private function _recursiveDirIterator($sFrom, $sTo, $sFuncName)
    {
        if ($sFuncName !== 'copy' && $sFuncName !== 'rename')
            throw new \Exception('Bad function name: \'' . $sFuncName . '\'');

        if (!is_dir($sFrom)) return false;

        $bRet = false;
        $oIterator = new \RecursiveIteratorIterator($this->getDirIterator($sFrom), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($oIterator as $sFromFile)
        {
            $sDest = $sTo . H2O_DS . $oIterator->getSubPathName();

            if ($sFromFile->isDir())
                $this->createDir($sDest);
            else
                if (!$bRet = $this->$sFuncName($sFromFile, $sDest)) break;
        }
        return $bRet;
    }

}