
const html_code = document.querySelector('.html-code textarea');
const css_code = document.querySelector('.css-code textarea');
const js_code = document.querySelector('.js-code textarea');
const result = document.querySelector('#result');

function run() {
    localStorage.setItem('html_code', html_code.value);
    localStorage.setItem('css_code', css_code.value);
    localStorage.setItem('js_code', js_code.value);

    result.contentDocument.body.innerHTML = `<style>${localStorage.css_code}</style>` + localStorage.html_code;
    result.contentWindow.eval(localStorage.js_code);
}

html_code.onkeyup = () => run();
css_code.onkeyup = () => run();
js_code.onkeyup = () => run();

html_code.value = localStorage.html_code;
css_code.value = localStorage.css_code;
js_code.value = localStorage.js_code;


// Lista para mantener un registro de los usuarios agregados
document.addEventListener("DOMContentLoaded", function () {
    loadCollaborators();
    document.getElementById("addCollaboratorButton").addEventListener("click", addCollaborator);

    // Cargar códigos al iniciar sesión
    loadCode('html');
    loadCode('css');
    loadCode('js');
});
function loadCollaborators() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../../server/php/mostrargrupo.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var collaborators = JSON.parse(xhr.responseText);
            collaborators.forEach(function (user) {
                addCollaboratorToUI(user.nombre_usuario, user.estado);
            });
        }
    };
    xhr.send();
}



function loadCode(type) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../../server/php/mostrarcodigogrupo.php?tipo_codigo=" + type, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var codigo = xhr.responseText;
                // Manejar el código recibido
                document.getElementById(`${type}Code`).value = codigo;
            } else if (xhr.status === 401) {
                alert("No autorizado. Por favor inicia sesión.");
                // Redirigir o manejar la falta de autorización
            } else {
                alert("Error al cargar el código.");
            }
        }
    };
    xhr.send();
}

function guardarCodigo() {
    var htmlCode = document.getElementById("htmlCode").value;
    var cssCode = document.getElementById("cssCode").value;
    var jsCode = document.getElementById("jsCode").value;

    saveCodeToServer('html', htmlCode, updateHtmlCode);
    saveCodeToServer('css', cssCode, updateCssCode);
    saveCodeToServer('js', jsCode, updateJsCode);
}

function saveCodeToServer(type, code, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../server/php/guardarcodigogrupo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                callback(xhr.responseText); // Llamar a la función de callback con el código devuelto
                console.log("Código guardado correctamente");
            } else {
                console.error("Error en la solicitud al servidor. Código de estado:", xhr.status);
                alert("Error en la comunicación con el servidor.");
            }
        }
    };
    var data = `tipo_codigo=${encodeURIComponent(type)}&codigo=${encodeURIComponent(code.trim())}`;
    xhr.send(data);
}
function updateHtmlCode(code) {
    document.getElementById("htmlCode").value = code;
}

function updateCssCode(code) {
    document.getElementById("cssCode").value = code;
}

function updateJsCode(code) {
    document.getElementById("jsCode").value = code;
}
function addCollaboratorToUI(username, status) {
    if (collaboratorExists(username)) {
        return; // Evitar agregar colaborador duplicado
    }

    var collaboratorDiv = document.createElement("div");
    collaboratorDiv.classList.add("collaborator");

    var img = document.createElement("img");
    img.src = "../img/niño.jpg";
    img.alt = username;
    collaboratorDiv.appendChild(img);

    var h3 = document.createElement("h3");
    h3.textContent = username;
    collaboratorDiv.appendChild(h3);

    var statusDiv = document.createElement("div");
    statusDiv.classList.add("status");

    var circleDiv = document.createElement("div");
    circleDiv.classList.add("circle");

    if (status === 'online') {
        circleDiv.classList.add("online");
    } else {
        circleDiv.classList.add("offline");
    }

    statusDiv.appendChild(circleDiv);
    collaboratorDiv.appendChild(statusDiv);

    var collaboratorsContainer = document.getElementById("collaboratorsContainer");
    collaboratorsContainer.appendChild(collaboratorDiv);
}

function collaboratorExists(username) {
    var collaboratorsContainer = document.getElementById("collaboratorsContainer");
    var collaborators = collaboratorsContainer.getElementsByClassName("collaborator");
    for (var i = 0; i < collaborators.length; i++) {
        if (collaborators[i].getElementsByTagName("h3")[0].textContent === username) {
            return true;
        }
    }
    return false;
}
function addCollaborator() {
    var collaboratorUser = document.getElementById("collaboratorUser").value.trim(); // Obtener nombre de usuario y quitar espacios en blanco

    if (collaboratorUser === "") {
        alert("Por favor ingresa el nombre de usuario.");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../server/php/validarusuario.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.exists) {
                        alert("Usuario agregado al grupo correctamente.");
                        loadCollaborators(); // Recargar lista de colaboradores después de agregar uno nuevo
                    } else {
                        alert(response.message || "Error al agregar el usuario al grupo.");
                    }
                } catch (e) {
                    console.error("Error al analizar JSON:", e);
                    alert("Error al procesar la respuesta del servidor.");
                }
            } else {
                console.error("Error en la comunicación con el servidor. Código de estado:", xhr.status);
                alert("Error en la comunicación con el servidor.");
            }
        }
    };
    
    xhr.send("username=" + encodeURIComponent(collaboratorUser));
}


function updateResult() {
    var htmlCode = document.getElementById("htmlCode").value;
    var cssCode = document.getElementById("cssCode").value;
    var jsCode = document.getElementById("jsCode").value;

    var resultFrame = document.getElementById("resultFrame");
    var result = resultFrame.contentWindow.document;

    result.open();
    result.write('<!DOCTYPE html><html><head><style>' + cssCode + '</style></head><body>' + htmlCode + '<script>' + jsCode + '<\/script></body></html>');
    result.close();
}
