<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{dropboxchooser_legend},dropboxApiKey,dropboxApiSecret,dropboxAccessToken';

$GLOBALS['TL_DCA']['tl_settings']['fields']['dropboxApiKey'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['dropboxApiKey'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['dropboxApiSecret'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['dropboxApiSecret'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['dropboxAccessToken'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['dropboxAccessToken'],
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50')
);
