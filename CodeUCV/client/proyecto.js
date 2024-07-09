document.getElementById('submitBtn').addEventListener('click', function() {
    var fileInput = document.getElementById('projectFile');
    var file = fileInput.files[0];
    if (!file) {
        alert('Por favor selecciona un archivo ZIP');
        return;
    }

    var reader = new FileReader();
    reader.onload = function(event) {
        var zip = new JSZip();
        zip.loadAsync(event.target.result).then(function(contents) {
            var sidebar = document.getElementById('sidebar');
            sidebar.innerHTML = '';
            var uniqueFolders = {};

            contents.forEach(function(relativePath, zipEntry) {
                var isFolder = zipEntry.dir;
                var name = zipEntry.name;
                var displayName = isFolder ? name.split('/')[0] : name.split('/').pop(); 
                
                if (isFolder && !uniqueFolders[name]) {
                    uniqueFolders[name] = true; 
                    var element = document.createElement('div');
                    element.classList.add('folder');

                    var icon = document.createElement('i');
                    icon.classList.add('fa-solid');
                    icon.classList.add('fa-folder');
                    element.appendChild(icon);

                    var text = document.createTextNode(displayName);
                    element.appendChild(text);

                    sidebar.appendChild(element);
                } else if (!isFolder) {
                    var element = document.createElement('div');
                    element.classList.add('file');

                    var icon = document.createElement('i');
                    icon.classList.add('fa-solid');
                    icon.classList.add('fa-file');
                    element.appendChild(icon);

                    var text = document.createTextNode(displayName);
                    element.appendChild(text);

                    sidebar.appendChild(element);

                    element.addEventListener('click', function() {
                        zip.files[name].async('string').then(function(content) {
                            document.getElementById('codeView').innerText = content;
                        });
                    });
                }
            });

            alert('Archivo subido correctamente');
        });
    };
    reader.readAsArrayBuffer(file);
});

document.getElementById('projectFile').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (file) {
        document.querySelector('label[for="projectFile"]').textContent = file.name;
    }
});

document.getElementById('cover-upload').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (!file) {
        return;
    }

    var previewContainer = document.getElementById('cover-preview');
    previewContainer.innerHTML = '';

    var fileType = file.type.split('/')[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        var previewElement;
        if (fileType === 'image') {
            previewElement = document.createElement('img');
            previewElement.src = e.target.result;
        } else if (fileType === 'video') {
            previewElement = document.createElement('video');
            previewElement.src = e.target.result;
            previewElement.controls = true;
        }

        previewContainer.appendChild(previewElement);
    };

    reader.readAsDataURL(file);
});


