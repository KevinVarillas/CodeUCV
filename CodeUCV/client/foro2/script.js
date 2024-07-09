function likeBtn(element) {
    if (element.classList.contains("fa-regular")) {
        element.classList.remove("fa-regular");
        element.classList.add("fa-solid");
        element.classList.add("active");
    } else {
        element.classList.remove("fa-solid");
        element.classList.add("fa-regular");
        element.classList.remove("active");
    }

    element.classList.add("animate");

    setTimeout(() => {
        element.classList.remove("animate");
    }, 300); // La duración de la animación en ms
}


