var DropboxWidget = (function() {

    'use strict';

    var config = {
        buttonContainerId: "dropboxBtnContainer",
        fileListContainerId: "dropboxSelectedFilesList",
        storageFieldId: '', // form hidden field where to store files

        dbxOptions: {
            success: function(files) {

                console.log('dbx success files', files);

                dbxFiles = files;

                // per ogni item salvo la relativa posizione
                for (var i = 0; i < dbxFiles.length; i++) {
                    dbxFiles[i].sortIdx = i;
                }

                renderFileList();

                // store files in hidden field immediately
                storeFiles();
            },
            linkType: "preview", // or "direct"
            multiselect: true
            //extensions: [".mp3",],
        },

        sortable: {
            dataIdAttr: 'data-position'
        }
    };

    var dbxFiles = [];

    var fileListContainer;
    var buttonContainer;
    var storageField;

    var formatBytes = function (bytes, decimals) {
        if (bytes == 0) return '0 Byte';
        var k = 1000;
        var dm = decimals + 1 || 3;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
    };

    var renderFileList = function (f) {
        console.log('renderFileList: files arg', f);

        var ul = fileListContainer;

        // empty container
        while (ul.hasChildNodes()) {
            ul.removeChild(ul.firstChild);
        }

        var files = f || dbxFiles;

        for (var i = 0; i < files.length; i++) {

            var li = document.createElement("li");
            li.setAttribute(config.sortable.dataIdAttr, files[i].sortIdx);

            var icon = document.createElement('img');
            icon.src = files[i].icon;
            icon.width = '16';
            icon.height = '16';
            li.appendChild(icon);

            var liText = document.createTextNode(files[i].name);
            li.appendChild(liText);

            var span = document.createElement('span');
            span.className = 'tl_gray';
            var txtfileSize = document.createTextNode(' (' + formatBytes(files[i].bytes) + ')');
            span.appendChild(txtfileSize);
            li.appendChild(span);

            ul.appendChild(li);
        }
    };

    var updateSorting = function (oldPos, newPos) {
        var oldId, newId;

        console.log('updateSorting:dbxFiles ', dbxFiles);

        for (var i = 0; i < dbxFiles.length; i++) {

            if (dbxFiles[i].sortIdx == oldPos) {
                oldId = i;
            }
            else if (dbxFiles[i].sortIdx == newPos) {
                newId = i;
            }
        }

        dbxFiles[ oldId ].sortIdx = newPos;
        dbxFiles[ newId ].sortIdx = oldPos;

        dbxFiles = dbxFiles.sortBy('sortIdx');
    };

    var storeFiles = function () {
        storageField.value = JSON.stringify(dbxFiles);
    };

    return {
        init: function (options) {

            console.log('DropboxWidget init');

            deepExtend(config, options);

            // build dropbox button
            var button = Dropbox.createChooseButton(config.dbxOptions);
            buttonContainer = document.getElementById(config.buttonContainerId);
            buttonContainer.appendChild(button);

            fileListContainer = document.getElementById(config.fileListContainerId);

            // load current saved files list
            storageField = document.getElementById(config.storageFieldId);
            if (storageField.value != "") {
                dbxFiles = JSON.parse(storageField.value);
                renderFileList();
            }

            // sortable init
            Sortable.create(fileListContainer, {
                dataIdAttr: config.sortable.dataIdAttr,
                onEnd: function (evt) {
                    console.log('old position', evt.oldIndex);
                    console.log('new position', evt.newIndex);

                    updateSorting(evt.oldIndex, evt.newIndex);

                    storeFiles();
                    renderFileList();
                }
            });
        }
    }
})();

Array.prototype.sortBy = function (p) {
    return this.slice(0).sort(function(a, b) {
        return (a[p] > b[p]) ? 1 : (a[p] < b[p]) ? -1 : 0;
    });
}

var deepExtend = function(out) {
    out = out || {};

    for (var i = 1; i < arguments.length; i++) {
        var obj = arguments[i];

        if (!obj)
            continue;

        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                if (typeof obj[key] === 'object')
                    deepExtend(out[key], obj[key]);
                else
                    out[key] = obj[key];
            }
        }
    }

    return out;
};