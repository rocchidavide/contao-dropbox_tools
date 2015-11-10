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
 * Register the namespace
 */
ClassLoader::addNamespace('DropboxTools');


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'DropboxTools\DropboxClient'			=> 'system/modules/dropbox_tools/classes/DropboxClient.php',

	// Widget
	'DropboxTools\WidgetDropboxChooser' 	=> 'system/modules/dropbox_tools/widgets/WidgetDropboxChooser.php',

	// Elements
	'DropboxTools\ContentDropboxToolsTest'	=> 'system/modules/dropbox_tools/elements/ContentDropboxToolsTest.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	// Elements
	'ce_dropboxtoolstest'	=> 'system/modules/dropbox_tools/templates/elements',
));