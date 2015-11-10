var DropboxWidget = (function() {

    var config = {
        buttonContainerId: "dropboxBtnContainer",
        fileListContainerId: "dropboxSelectedFilesList",
        storageFieldId: '', // form hidden field where to store files

        dbxOptions: {
            success: function(files) {
                updateFileList(files);
                storageField.value = encodeURIComponent(JSON.stringify(files));
            },
            linkType: "preview", // or "direct"
            multiselect: true
            //extensions: [".mp3",],
        }
    };

    var fileListContainer;
    var buttonContainer;
    var storageField;

    var formatBytes = function(bytes, decimals) {
        if (bytes == 0) return '0 Byte';
        var k = 1000;
        var dm = decimals + 1 || 3;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
    };

    var updateFileList = function(files) {
        var ul = fileListContainer;

        console.log(fileListContainer);

        // empty container
        while (ul.hasChildNodes()) {
            ul.removeChild(ul.firstChild);
        }

        for (var i = 0; i < files.length; i++) {

            var li = document.createElement("li");
            //li.setAttribute('data-id', i);
            //var a = document.createElement('a');

            var icon = document.createElement('img');
            icon.setAttribute('src', files[i].icon);
            icon.setAttribute('width', '16');
            icon.setAttribute('height', '16');

            var aText = document.createTextNode(files[i].name);

            var span = document.createElement('span');
            span.className = 'tl_gray';
            var txtfileSize = document.createTextNode(' (' + formatBytes(files[i].bytes) + ')');
            span.appendChild(txtfileSize);

            li.appendChild(icon);
            li.appendChild(aText);
            li.appendChild(span);

            //a.appendChild(icon);
            //a.appendChild(aText);
            //a.setAttribute('target', '_blank');

            //a.href = files[i].link;

            //li.appendChild(a);
            ul.appendChild(li);
        }
    };

    return {
        init: function(options) {

            console.log('DropboxWidget init');

            //console.log('config before', config);

            // TODO deep extend
            function extend(a, b) {
                var c = {};
                for(var p in a)
                    c[p] = (b[p] == null) ? a[p] : b[p];
                return c;
            }
            config = extend(config, options);

            //console.log('config after', config);

            // build dropbox button
            var button = Dropbox.createChooseButton(config.dbxOptions);
            buttonContainer = document.getElementById(config.buttonContainerId);
            buttonContainer.appendChild(button);

            // sortable init
            fileListContainer = document.getElementById(config.fileListContainerId);

            // load current saved files
            storageField = document.getElementById(config.storageFieldId);
            if (storageField.value != "") {
                updateFileList(JSON.parse(decodeURIComponent(storageField.value)));
            }

            Sortable.create(fileListContainer, {
                onUpdate: function (evt/**Event*/){
                    var item = evt.item; // the current dragged HTMLElement
                    console.log(item);
                }
            });
        }
    }
})();
