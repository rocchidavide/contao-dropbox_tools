<?php

/**
 * Dropbox tools extension for Contao Open Source CMS
 *
 * Copyright (C) 2015 Davide Rocchi
 *
 * @package dropbox_tools
 * @author  Davide Rocchi <http://www.daviderocchi.it>
 * @license LGPL
 */

namespace DropboxTools;

# Include the Dropbox SDK libraries
require_once TL_ROOT . '/system/modules/dropbox_tools/vendor/dropbox-sdk-php/lib/Dropbox/autoload.php';
use \Dropbox as dbx;


class ContentDropboxToolsTest extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_dropboxtoolstest';

    /**
     * Querystring parameter prefix
     * @var string
     */
    protected $strQsParam = 'file';

	/*
	 * il valore dell'argomento file cambierà se proveniente da un file da path o da chooser:
	 * nel secondo caso
	 * */
    public function generate()
    {
	    Dump($_POST);
        $pathFile = \Input::get($this->strQsParam, true);

	    $isPath = substr($pathFile, 0, 1) === '/';

        if ($pathFile != '')
        {
            $accessToken = \Config::get('dropboxAccessToken');
            $dbxClient = new \DropboxClient($accessToken, "PHP-Example/1.0");

            try
            {
	            if (! $isPath)
	            {
		            $files = json_decode(urldecode($this->dropboxChooserFiles), true);

		            foreach ($files as $f)
		            {
			            $basename = urldecode(explode('?', basename($f['link']))[0]);
			            if ($basename == $pathFile)
			            {
				            $metadata = $dbxClient->getMetadataSharedLink($f['link']);
				            $pathFile = $metadata['path'];
			            }
		            }
	            }

                $sharedLink = $dbxClient->createTemporaryDirectLink($pathFile);
                //$sharedLink = $dbxClient->createShareableLink($pathFile);
            }
            catch (dbx\Exception_BadRequest $ex)
            {
                print("Error loading <app-info-file>: ".$ex->getMessage()."\n");
                // fwrite(STDERR, "Error loading <app-info-file>: ".$ex->getMessage()."\n");
                die;
            }

            //Dump($sharedLink);
            $this->redirect($sharedLink[0]);
        }

        return parent::generate();
    }


    public function compile()
    {
        if (TL_MODE == 'FE')
        {
            $strHref = \Environment::get('request');

            // Remove an existing file parameter (see #5683)
            if (preg_match('/(&(amp;)?|\?)' . $this->strQsParam . '=/', $strHref))
            {
                $strHref = preg_replace('/(&(amp;)?|\?)' . $this->strQsParam . '=[^&]+/', '', $strHref);
            }
            $strDownloadBaseUrl = $strHref . ((\Config::get('disableAlias') || strpos($strHref, '?') !== false) ? '&amp;' : '?') . $this->strQsParam . '=';

            //$appInfo = new dbx\AppInfo(\Config::get('dropboxApiKey'), \Config::get('dropboxApiSecret'));
            //$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");
            //$authorizeUrl = $webAuth->start();

            $accessToken = \Config::get('dropboxAccessToken');
            $dbxClient = new \DropboxClient($accessToken, "PHP-Example/1.0");


	        // =========================================================================================================
	        // get metadata by chooser
	        // =========================================================================================================
	        if ($this->dropboxChooserFiles !== '')
	        {
		        $children = json_decode($this->dropboxChooserFiles, true);

//		        foreach ($filesList as $f)
//		        {
//			        $f['path'] = $f['name'];
//			        //$f['download_link'] = $dbxClient->createTemporaryDirectLink($f['link']);
//		        }

		        //$this->Template->filesInFolder = $filesList;
	        }

	        // $previewLink = 'https://www.dropbox.com/s/wq6u9zx1psa9nrh/2012-11-26%201%20Battesimo.pdf?dl=0';
			// $metadata = $dbxClient->getMetadataSharedLink($previewLink);


	        // =========================================================================================================
	        // get metadata by path
	        // =========================================================================================================
            //$metadata = $dbxClient->getMetadataWithChildren(urldecode($this->dropboxPath));

//            $pathError = dbx\Path::findError($this->dropboxPath);
//            if ($pathError !== null)
//            {
//                $this->Template->errors = "Invalid <dropbox-path>: $pathError";
//                return;
//            }

	        Dump($children);

	        if ($this->dropboxPath !== '')
	        {
		        if ($metadata === null)
		        {
			        $this->Template->errors = "No file or folder at that path.";
			        return;
		        }

		        // If it's a folder, remove the 'contents' list from $metadata; print that stuff out after.
		        $children = null;
		        if ($metadata['is_dir'])
		        {
			        $children = $metadata['contents'];
			        unset( $metadata['contents'] );
		        }

		        $this->Template->metadata = $metadata;
	        }

	        $ff = array();
	        foreach ($children as $f)
	        {
		        if (array_key_exists('path', $f))
		        {
			        $name = dbx\Path::getName( $f['path'] );
		        }
		        else
		        {
			        $name = $f['name'];
		        }

		        // Put a "/" after folder names.
		        $f['name'] = $name . ( $f['is_dir'] ? '/' : '' );

		        if ( $f['is_dir'] )
		        {
			        $f['download_link'] = '';
		        }
		        else
		        {
			        $f['download_link'] = $strDownloadBaseUrl . \System::urlEncode($name);
		        }

		        $ff[] = $f;
	        }

	        $this->Template->filesInFolder = $ff;

	        Dump($GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__']);
        }
    }
}
