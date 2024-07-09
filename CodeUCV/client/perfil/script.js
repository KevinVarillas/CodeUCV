// Manejo del avatar
document.addEventListener('DOMContentLoaded', () => {
    const avatarBtn = document.getElementById('avatar-btn');
    const avatarImg = document.getElementById('avatar-img');
    const fileInput = document.getElementById('file-input');

    // Simular clic en el input de tipo file al hacer clic en el botón del avatar
    avatarBtn.addEventListener('click', function() {
        fileInput.click();
    });

    // Mostrar la imagen seleccionada en el avatar
    fileInput.addEventListener('change', function() {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                avatarImg.src = reader.result;
            };
            reader.readAsDataURL(file);
        }
    });
});

// Manejo del fondo de portada
document.addEventListener('DOMContentLoaded', () => {
    const portadaBtn = document.querySelector('.boton-portada');
    const portadaContainer = document.querySelector('.perfil-usuario-portada');

    // Simular clic en el input de tipo file para cambiar el fondo de la portada
    portadaBtn.addEventListener('click', function() {
        const fileInputPortada = document.createElement('input');
        fileInputPortada.type = 'file';
        fileInputPortada.accept = 'image/*';
        fileInputPortada.style.display = 'none';

        // Aplicar la imagen seleccionada como fondo de la portada
        fileInputPortada.addEventListener('change', function() {
            const file = fileInputPortada.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    portadaContainer.style.backgroundImage = `url('${reader.result}')`;
                };
                reader.readAsDataURL(file);
            }
        });

        // Simular clic en el input de tipo file
        fileInputPortada.click();
    });
});



    // Mostrar el input de edición al hacer clic en el nombre de usuario
    nombreUsuario.addEventListener('click', () => {
        nombreInput.value = nombreUsuario.textContent;
        nombreUsuario.style.display = 'none';
        nombreInput.style.display = 'block';
        nombreInput.focus();
    });

    // Guardar el nombre de usuario al perder el foco del input
    nombreInput.addEventListener('blur', () => {
        nombreUsuario.textContent = nombreInput.value;
        nombreInput.style.display = 'none';
        nombreUsuario.style.display = 'block';
    });

    // Guardar el nombre de usuario al presionar la tecla Enter
    nombreInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            nombreUsuario.textContent = nombreInput.value;
            nombreInput.style.display = 'none';
            nombreUsuario.style.display = 'block';
        }
    });
    
    