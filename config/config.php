<?php

/*
	The vary basic thing of an extension is the configuration file.
	It is called config.php and contains information about modules,
	content elements, hooks and many other things.
	This way we can tell Contao what our extension will do and which
	sectors it needs to be registered in.
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
$GLOBALS['TL_CTE']['files']['dropboxTools'] = 'ContentDropboxToolsTest';