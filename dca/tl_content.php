<?php 

/**
 * Table tl_content
 *
 * @copyright  Davide Rocchi 2015
 * @author  Davide Rocchi <http://www.daviderocchi.it>
 */

/**
* Add palettes to tl_content
*/

$GLOBALS['TL_DCA']['tl_content']['palettes']['dropboxTools'] = '{type_legend},type,headline;{dropbox_legend},dropboxPath,dropboxChooserFiles;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';


/**
 * Add fields to tl_content
 */

$GLOBALS['TL_DCA']['tl_content']['fields']['dropboxPath'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['dropboxPath'],
    'inputType'               => 'text',
    //'eval'                    => array('tl_class'=>'w50'),
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