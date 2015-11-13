<?php

/**
 * widget_hours extension for Contao Open Source CMS
 *
 * Copyright (C) 2015 Davide Rocchi
 *
 * @package widget_hours
 * @author  Codefog <http://codefog.pl>
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */

namespace DropboxTools;


/**
 * Class WidgetDropboxChooser
 *
 * see system/modules/core/widgets/FileTree.php
 */
class WidgetDropboxChooser extends \Widget
{

	/**
	 * Submit user input
	 * @var boolean
	 * se lo commento, non salva: chiedere a Kamil
	 */
	protected $blnSubmitInput = true;


	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_widget';


	/**
	 * Generate the widget and return it as string
	 * @return string
	 */
	public function generate()
	{
		// Add stylesheet
		$GLOBALS['TL_CSS'][] = 'system/modules/dropbox_tools/assets/widgetdropbox.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/dropbox_tools/assets/widgetdropbox.js';
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/dropbox_tools/vendor/sortable/Sortable.min.js';

		return '
			<div class="selector_container">'
		       . (($this->varValue != '') ? '<p class="sort_hint">' . $GLOBALS['TL_LANG']['MSC']['dragItemsHint'] . '</p>' : '')
		       . '<ul id="dropboxSelectedFilesList"></ul>
				<div id="dropboxBtnContainer"></div>
			</div>

			<input type="hidden" name="' . $this->strName . '" id="ctrl_' . $this->strId . '" value="' . htmlspecialchars($this->varValue) . '">

			<script	src="https://www.dropbox.com/static/api/2/dropins.js"
					id="dropboxjs"
					data-app-key="' . \Config::get('dropboxApiKey') . '"></script>

			<script type="text/javascript">
				DropboxWidget.init({
					buttonContainerId: "dropboxBtnContainer",
					fileListContainerId: "dropboxSelectedFilesList",
					storageFieldId: "ctrl_' . $this->strId . '"
				});
			</script>
		';
	}
}
