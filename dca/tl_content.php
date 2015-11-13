<?php 

/**
 * Table tl_content
 *
 * @copyright  Davide Rocchi 2015
 * @author  Davide Rocchi <http://www.daviderocchi.it>
 */


//$GLOBALS['TL_DCA']['tl_content']['config']['submit_callback'] = array(array('tl_content_dropboxtools', 'saveDropboxPathField'));


/**
* Add palettes to tl_content
*/

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] =  'dropboxSource';
$GLOBALS['TL_DCA']['tl_content']['palettes']['dropboxTools'] = '{type_legend},type,headline;{dropbox_legend},dropboxSource;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['subpalettes']['dropboxSource_path'] = 'dropboxPath';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['dropboxSource_chooser'] = 'dropboxChooserFiles';


/**
 * Add fields to tl_content
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['dropboxSource'] = array
(
	'label'         => array('Seleziona sorgente dropbox', ''),
	'default'       => 'chooser',
	'inputType'     => 'radio',
	'options'       => array('path', 'chooser'),
	//'reference'     => &$GLOBALS['TL_LANG']['tl_content']['dropboxSources'],
	'eval'          => array('mandatory'=>true, 'submitOnChange'=>true),
	'sql'           => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dropboxPath'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['dropboxPath'],
    'inputType'               => 'text',
//	'save_callback'           => //array(
//		array('tl_content_dropboxtools', 'saveDropboxPathField'),
	//),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dropboxChooserFiles'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['dropboxChooserFiles'],
    'exclude'                 => true,
    'inputType'               => 'dropboxChooserWidget',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'long', 'multiple'=>true),
    'sql'                     => "blob NULL",
);


//class tl_content_dropboxtools extends Backend
//{
//	public function saveDropboxPathField($varValue, DataContainer $dc)
//	{
//		die();
//	}
//}