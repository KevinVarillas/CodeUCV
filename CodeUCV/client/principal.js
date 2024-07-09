const menuItems = document.querySelectorAll('.menu-item');
const feeditems = document.querySelectorAll('.feed-item');

const archivoItems = document.querySelectorAll('.subirachivo-item');
const messagesNotification = document.querySelector('#message-notification');
const messages = document.querySelector('.messages');
const message = messages.querySelectorAll('.message');
const modal = document.getElementById("modal");
const btnAbrirModal = document.getElementById('btnAbrirModal');
const mostrarTemasBtn = document.getElementById('mostrarTemas');
const theme = document.querySelector('#theme');
const themeModal = document.querySelector('.customize-theme');
const customize = document.querySelector('.customize-theme');
const fontSizes = document.querySelectorAll('.choose-size span');
const root = document.querySelector(':root');
const colorPalette = document.querySelectorAll('.choose-color span');
const Bg1 = document.querySelector('.bg-1');
const Bg2 = document.querySelector('.bg-2');
const Bg3 = document.querySelector('.bg-3');

// Cambiar el elemento activo en el menú
const changeActiveItem = () => {
    menuItems.forEach(item => {
        item.classList.remove('active');
    });
};

menuItems.forEach(item => {
    item.addEventListener('click', () => {
        changeActiveItem();
        item.classList.add('active');
        if (item.id != 'notifications') {
            document.querySelector('.notifications-popup').style.display = 'none';
        } else {
            document.querySelector('.notifications-popup').style.display = 'block';
            document.querySelector('#notifications .notification-count').style.display = 'none';
        }
    });
});



// Color de mensaje y desaparecer conteo
messagesNotification.addEventListener('click', () => {
    messages.style.boxShadow = '0 0 1rem var(--color-primary)';
    messagesNotification.querySelector('.notification-count').style.display = 'none';
    setTimeout(() => {
        messages.style.boxShadow = 'none';
    }, 2000);
});

// Fuentes
const removeSizeSelector = () => {
    fontSizes.forEach(size => {
        size.classList.remove('active');
    });
};

fontSizes.forEach(size => {
    size.addEventListener('click', () => {
        removeSizeSelector();
        let fontSize;
        size.classList.toggle('active');

        if (size.classList.contains('font-size-1')) {
            fontSize = '10px';
            root.style.setProperty('--sticky-top-left', '5.4rem');
            root.style.setProperty('--sticky-top-right', '5.4rem');
        } else if (size.classList.contains('font-size-2')) {
            fontSize = '13px';
            root.style.setProperty('--sticky-top-left', '5.4rem');
            root.style.setProperty('--sticky-top-right', '-7rem');
        } else if (size.classList.contains('font-size-3')) {
            fontSize = '16px';
            root.style.setProperty('--sticky-top-left', '-2rem');
            root.style.setProperty('--sticky-top-right', '-17rem');
        } else if (size.classList.contains('font-size-4')) {
            fontSize = '19px';
            root.style.setProperty('--sticky-top-left', '-5rem');
            root.style.setProperty('--sticky-top-right', '-25rem');
        } else if (size.classList.contains('font-size-5')) {
            fontSize = '22px';
            root.style.setProperty('--sticky-top-left', '-12rem');
            root.style.setProperty('--sticky-top-right', '-35rem');
        }

        document.querySelector('html').style.fontSize = fontSize;
    });
});

const changeActiveColorClass = () => {
    colorPalette.forEach(colorPicker => {
        colorPicker.classList.remove('active');
    });
};

colorPalette.forEach(color => {
    color.addEventListener('click', () => {
        let primaryHue;
        changeActiveColorClass();
        if (color.classList.contains('color-1')) {
            primaryHue = 291;
        } else if (color.classList.contains('color-2')) {
            primaryHue = 52;
        } else if (color.classList.contains('color-3')) {
            primaryHue = 352;
        } else if (color.classList.contains('color-4')) {
            primaryHue = 152;
        } else if (color.classList.contains('color-5')) {
            primaryHue = 202;
        }
        color.classList.add('active');
        root.style.setProperty('--primary-color-hue', primaryHue);
    });
});

let lightColorLightness;
let whiteColorLightness;
let darkColorLightness;

const changeBG = () => {
    root.style.setProperty('--light-color-lightness', lightColorLightness);
    root.style.setProperty('--white-color-lightness', whiteColorLightness);
    root.style.setProperty('--dark-color-lightness', darkColorLightness);
};

Bg1.addEventListener('click', () => {
    Bg1.classList.add('active');
    Bg2.classList.remove('active');
    Bg3.classList.remove('active');
    window.location.reload();
});

Bg2.addEventListener('click', () => {
    darkColorLightness = '95%';
    whiteColorLightness = '20%';
    lightColorLightness = '15%';

    Bg2.classList.add('active');
    Bg1.classList.remove('active');
    Bg3.classList.remove('active');
    changeBG();
});

Bg3.addEventListener('click', () => {
    darkColorLightness = '95%';
    whiteColorLightness = '10%';
    lightColorLightness = '0%';

    Bg3.classList.add('active');
    Bg1.classList.remove('active');
    Bg2.classList.remove('active');
    changeBG();
});

function loadContent(page) {
    const iframe = document.getElementById('contentFrame');
    const defaultContent = document.getElementById('default-content');

    if (page === 'dashboard') {
        iframe.style.display = 'none';
        defaultContent.style.display = 'block';
    } else {
        iframe.src = page;
        iframe.style.display = 'block';
        defaultContent.style.display = 'none';
    }
}

// Función para establecer el enlace activo
function setActive(element) {
    allSideMenu.forEach(item => {
        item.parentElement.classList.remove('active');
    });
    element.parentElement.classList.add('active');
}

window.onload = function() {
    loadContent('dashboard');
};

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById("modal");

    // Abrir el modal al hacer clic en el botón
    const btnAbrirModal = document.getElementById('btnAbrirModal');
    btnAbrirModal.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });

    // Cerrar el modal al hacer clic fuera de él
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            modal.classList.add('hidden');
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const mostrarTemasBtn = document.getElementById('mostrarTemas');
    const customizeTheme = document.getElementById('customize-theme');

    mostrarTemasBtn.addEventListener('click', function() {
        customizeTheme.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!customizeTheme.contains(event.target) && event.target !== mostrarTemasBtn && !mostrarTemasBtn.contains(event.target)) {
            customizeTheme.classList.add('hidden');
        }
    });
});



//opciones de edicion
// Script para mostrar el menú de opciones al hacer clic en el ícono de edición
document.addEventListener('DOMContentLoaded', function() {
    const editIcons = document.querySelectorAll('.edit');

    editIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const opciones = this.parentElement.querySelector('.opciones');
            if (opciones) {
                opciones.classList.toggle('hidden');
            }
        });
    });
});

const feeditems2 = document.querySelectorAll('.feed-item');

document.addEventListener('DOMContentLoaded', function () {
    const feeditems2 = document.querySelectorAll('.feed-item');

    feeditems2.forEach(item => {
        const editButton = item.querySelector('.edit');
        const opcionesContainer = item.querySelector('.opciones');

        // Mostrar u ocultar opciones al hacer clic en el ícono de edición
        editButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Evitar la propagación del evento
            opcionesContainer.classList.toggle('visible');
        });

        // Cerrar opciones al hacer clic fuera de ellas
        document.addEventListener('click', (event) => {
            if (!opcionesContainer.contains(event.target) && event.target !== editButton) {
                opcionesContainer.classList.remove('visible');
            }
        });
    });
});



//visualizar codigo
document.addEventListener('DOMContentLoaded', function() {
    const visualizarBotones = document.querySelectorAll('.visualizar-codigo');
    
    visualizarBotones.forEach(boton => {
        boton.addEventListener('click', function() {
            const proyectoId = boton.getAttribute('data-proyecto');
            
            const modal = document.querySelector(`.modalcodigo[data-proyecto="${proyectoId}"]`);
            if (!modal) {
                console.error('Modal no encontrado para el proyecto ID:', proyectoId);
                return;
            }
            modal.classList.remove('hidden'); 
            fetch(`../server/subirarchivo/obtener_proyecto.php?id=${proyectoId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud: ' + response.status);
                    }
                    return response.json(); 
                })
                .then(data => {
                    if (!data.archivo_zip) {
                        throw new Error('No se recibió la ruta del archivo ZIP');
                    }
                    console.log('Ruta del archivo ZIP recibida:', data.archivo_zip);
                    const rutaArchivoZip = `../server/subirarchivo/uploads/${data.archivo_zip}`;
                    return fetch(rutaArchivoZip); 
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al obtener el archivo ZIP: ' + response.status);
                    }
                    return response.blob(); 
                })
                .then(blob => {
                    return new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onload = () => resolve(reader.result);
                        reader.onerror = reject;
                        reader.readAsArrayBuffer(blob);
                    });
                })
                .then(arrayBuffer => {
                    return JSZip.loadAsync(arrayBuffer);
                })
                .then(zip => {
                    const sidebar = modal.querySelector('.sidebar');
                    const codeView = modal.querySelector('.content');
                    
                    sidebar.innerHTML = '';
                    codeView.innerHTML = '';

                    const folders = {};

                    zip.forEach((relativePath, zipEntry) => {
                        const pathParts = zipEntry.name.split('/');
                        const fileName = pathParts.pop();
                        const folderPath = pathParts.join('/'); 
                        const isFolder = zipEntry.dir; 

                        if (!folders[folderPath]) {
                            folders[folderPath] = [];
                        }

                        folders[folderPath].push({
                            name: fileName,
                            isFolder: isFolder
                        });
                    });

                    for (const folderPath in folders) {
                        const folderFiles = folders[folderPath];
                        if (folderPath !== "") {
                            const folderElement = document.createElement('div');
                            folderElement.classList.add('folder');

                            const folderName = folderPath.split('/').pop(); // Obtener el nombre de la carpeta
                            const folderIcon = document.createElement('i');
                            folderIcon.classList.add('fa-solid', 'fa-folder'); 
                            folderElement.appendChild(folderIcon);

                            const folderText = document.createTextNode(folderName);
                            folderElement.appendChild(folderText);

                            sidebar.appendChild(folderElement);
                        }

                        folderFiles.forEach(file => {
                            if (!file.isFolder) { 
                                const fileElement = document.createElement('div');
                                fileElement.classList.add('file');

                                const fileIcon = document.createElement('i');
                                fileIcon.classList.add('fa-solid', 'fa-file');
                                fileElement.appendChild(fileIcon);

                                const fileNameText = document.createTextNode(file.name);
                                fileElement.appendChild(fileNameText);

                                sidebar.appendChild(fileElement);

                                fileElement.addEventListener('click', () => {
                                    zip.files[`${folderPath}/${file.name}`].async('string').then(content => {
                                        codeView.innerText = content;
                                    });
                                });
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al obtener y procesar el archivo ZIP:', error);
                    modal.classList.add('hidden');
                    alert('Hubo un error al cargar el contenido del archivo ZIP.');
                });
        });
    });

    window.onclick = function(event) {
        if (event.target.classList.contains('modalcodigo')) {
            event.target.classList.add('hidden');
        }
    };
});



//VISUALIZACION DEOPCIONESSEGUN USUARIOS 
document.addEventListener('DOMContentLoaded', function() {
    const eliminarEnlaces = document.querySelectorAll('.eliminar-publicacion');
    const visualizarBotones = document.querySelectorAll('.visualizar-codigo, .descargar-codigo');

    eliminarEnlaces.forEach(enlace => {
        enlace.addEventListener('click', function(event) {
            event.preventDefault();
            const proyectoId = enlace.getAttribute('data-proyecto');

            if (confirm('¿Estás seguro de que deseas eliminar esta publicación?')) {
                fetch(`../server/subirarchivo/eliminarproyecto.php?id=${proyectoId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: proyectoId })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al eliminar la publicación.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Publicación eliminada correctamente.');
                        location.reload(); // Recargar la página después de eliminar
                    })
                    .catch(error => {
                        console.error('Error al eliminar la publicación:', error);
                        alert('Hubo un error al eliminar la publicación.');
                    });
            }
        });
    });

    visualizarBotones.forEach(boton => {
        boton.addEventListener('click', function(event) {
            const proyectoId = boton.getAttribute('data-proyecto');
            // Aquí puedes implementar la lógica para visualizar el código según las necesidades de tu aplicación
        });
    });
});

function likeBtn(element) {
    var postId = element.getAttribute('data-proyecto');
    var likeCountSpan = element.closest('.interaction-button').querySelector('.like-count');
    var currentCount = parseInt(likeCountSpan.textContent);
    var isLiked = element.classList.contains("fa-solid");

    if (isLiked) {
        element.classList.remove("fa-solid", "active");
        element.classList.add("fa-regular");
        likeCountSpan.textContent = currentCount - 1; // Decrementa el conteo de likes
    } else {
        element.classList.remove("fa-regular");
        element.classList.add("fa-solid", "active");
        likeCountSpan.textContent = currentCount + 1; // Incrementa el conteo de likes
    }

    // Añadir la clase de animación
    element.classList.add("animate");

    // Remover la clase de animación después de que la animación termine
    setTimeout(() => {
        element.classList.remove("animate");
    }, 300); // La duración de la animación en ms

    // Enviar solicitud AJAX para actualizar el like en la base de datos
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../server/php/like.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Actualización exitosa en la base de datos
        }
    };
    xhr.send("post_id=" + postId + "&like=" + (!isLiked));
}

function saveBtn(element) {
    if (element.classList.contains("active")) {
        element.classList.remove("active");
    } else {
        element.classList.add("active");
    }

    // Añadir la clase de animación
    element.classList.add("animate");

    // Remover la clase de animación después de que la animación termine
    setTimeout(() => {
        element.classList.remove("animate");
    }, 300); // La duración de la animación en ms
}



document.addEventListener('DOMContentLoaded', function() {
    // Obtén todos los botones de descarga por su clase
    var buttons = document.querySelectorAll('.descargar-codigo');

    // Agrega un controlador de eventos a cada botón
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Obtén el valor del atributo data-proyecto
            var proyectoId = this.getAttribute('data-proyecto');

            // Realiza una solicitud AJAX para obtener la ruta del archivo ZIP
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../server/php/descargararchivozip.php?id=' + proyectoId, true);

            // Cuando la solicitud esté lista
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var rutaArchivo = xhr.responseText.trim(); // Obtener la ruta del archivo del servidor

                    // Crear un enlace para iniciar la descarga
                    var a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = '../server/subirarchivo/uploads/' + rutaArchivo; // Ruta completa al archivo en el servidor
                    document.body.appendChild(a);
                    a.click(); // Iniciar la descarga
                    document.body.removeChild(a); // Eliminar el elemento <a> creado después de la descarga
                } else {
                    alert('Error al obtener la ruta del archivo ZIP'); // Manejar errores
                }
            };

            // Enviar la solicitud
            xhr.send();
        });
    });
});


