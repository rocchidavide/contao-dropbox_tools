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
		$GLOBALS['TL_CSS']['dropboxChooserWidget'] = 'system/modules/dropbox-tools/assets/widgetdropbox.css';
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/dropbox-tools/assets/widgetdropbox.js';

		return '
			<div class="selector_container">'
		       . (($this->varValue != '') ? '<p class="sort_hint">' . $GLOBALS['TL_LANG']['MSC']['dragItemsHint'] . '</p>' : '')
		       . '<ul id="dropboxSelectedFilesList" class="zsortable"></ul>

				<p><div id="dropboxBtnContainer"></div></p>
			</div>

			<input type="hidden" name="' . $this->strName . '" id="ctrl_' . $this->strId . '" value="' . $this->varValue . '">

			<script src="http://rubaxa.github.io/Sortable/Sortable.js"></script>
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

			<script type="text/javascript">
//				var filesList = document.getElementById("ctrl_' . $this->strId . '");
//
//				if (filesList.value != "") {
//					dropboxWidget.updateFilesList(JSON.parse(decodeURIComponent(filesList.value)));
//				}
//
//				Sortable.create(document.getElementById("dropboxSelectedFilesList"), {
//					onUpdate: function (evt/**Event*/){
//				        var item = evt.item; // the current dragged HTMLElement
//				        console.log(item);
//					}
//				});
//
//				var options = {
//				    success: function(files) {
//				    	dropboxWidget.updateFilesList(files);
//				        filesList.value = encodeURIComponent(JSON.stringify(files));
//				    },
//				    linkType: "preview", // or "direct"
//				    multiselect: true
//				    //extensions: [".mp3",],
//				};
//				var button = Dropbox.createChooseButton(options);
//				document.getElementById("dropboxBtnContainer").appendChild(button);
			</script>
		';
	}
}
