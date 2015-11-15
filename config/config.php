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


/**
 * Vendor versions
 */
define('DROPBOX_SDK_PHP', '1.1.5');
define('SORTABLE', '1.4.2');


/**
 * Back end form fields
 */
$GLOBALS['BE_FFL']['dropboxChooserWidget'] = 'WidgetDropboxChooser';


/**
 * Content elements
 */
$GLOBALS['TL_CTE']['files']['dropboxDownloads'] = 'ContentDropboxDownloads';
$GLOBALS['TL_CTE']['files']['dropboxTools'] = 'ContentDropboxToolsTest';