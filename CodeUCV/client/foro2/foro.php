<?php
error_reporting(0);
session_start();
$varsesion = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : null;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro Colaborativo</title>
    <link rel="stylesheet" href="foro.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>

    <nav>
        <h2>Categorías</h2>
        <div class="comment-bar">
            <div class="comment-buttons">
                <button class="categoria-btn" data-categoria="Estructura de datos">Estructura de datos</button>
                <button class="categoria-btn" data-categoria="Programación orientada a objetos">Programación orientada a
                    objetos</button>
                <button class="categoria-btn" data-categoria="Inteligencia artificial">Inteligencia artificial</button>
                <button class="categoria-btn" data-categoria="Python">Python</button>
                <button class="categoria-btn" data-categoria="CSS">CSS</button>
            </div>
        </div>
    </nav>

    <main>
        <div class="comments">
            <div class="comment-input">
                <form id="commentForm" method="POST">
                    <input type="hidden" name="nombre_usuario" value="<?php echo $varsesion; ?>">
                    <input type="text" name="comentarios" id="commentInput" placeholder="Escribe tu comentario...">
                    <input type="hidden" name="categoria" id="categoriaInput" value="">
                    <button type="submit" class="publicar-btn">Publicar</button>
                </form>
            </div>
            <div id="commentSection">
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function () {
            function loadComments(categoria) {
                $.ajax({
                    url: "../../server/ListaComentario.php",
                    method: "GET",
                    data: { categoria: categoria },
                    dataType: "json",
                    success: function (response) {
                        var commentSection = $("#commentSection");
                        commentSection.empty();

                        if (response.length > 0) {
                            $.each(response, function (index, comment) {
                                var commentHtml = "<div class='comment' data-comment-id='" + comment.id + "'>" +
                                    "<div class='user-info'>" +
                                    "<img src='../img/joven.jpg' alt='User Image'>" +
                                    "<span>" + comment.nombre_usuario + "</span>" +
                                    "</div>" +
                                    "<div class='comment-text'>" +
                                    "<p>" + comment.comentarios + "</p>" +
                                    "</div>" +
                                    "<div class='comment-actions'>" +
                                    "<button><i class='fa-regular fa-heart like-icon' onclick='likeBtn(this)'></i></button>" +
                                    "<button class='reply-btn'><i class='fa-solid fa-comment-dots'></i></button>" +
                                    "</div>" +
                                    "<div class='reply-form'></div>" + 
                                    "</div>";

                                commentSection.append(commentHtml);

                                var repliesContainer = "<div class='replies-container' data-comment-id='" + comment.id + "-replies'></div>";
                                commentSection.append(repliesContainer);

                                if (comment.respuestas && comment.respuestas.length > 0) {
                                    $.each(comment.respuestas, function (index, respuesta) {
                                        var replyHtml = "<div class='reply'>" +
                                            "<div class='user-info'>" +
                                            "<img src='../img/joven.jpg' alt='User Image'>" +
                                            "<span>" + respuesta.nombre_usuario + "</span>" +
                                            "</div>" +
                                            "<div class='reply-text'>" +
                                            "<p>" + respuesta.reply_comment + "</p>" +
                                            "</div>" +
                                            "</div>";

                                        commentSection.find("[data-comment-id='" + comment.id + "-replies']").append(replyHtml);
                                    });
                                }
                            });
                        } else {
                            commentSection.append("<p>No se encontraron comentarios en esta categoría.</p>");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Error al cargar los comentarios. Por favor, inténtalo de nuevo más tarde.");
                    }
                });
            }

            loadComments("");

            $(document).on("click", ".reply-btn", function () {
                var commentId = $(this).closest('.comment').data('comment-id');
                var replyForm = "<form class='replyForm'>" +
                    "<input type='hidden' name='nombre_usuario' value='<?php echo $varsesion; ?>'>" +
                    "<input type='hidden' name='parent_comment_id' value='" + commentId + "'>" +
                    "<input type='text' name='reply_comment' placeholder='Escribe tu respuesta...'>" +
                    "<button type='submit'>Responder</button>" +
                    "</form>";
                $(this).closest('.comment').find('.reply-form').html(replyForm).toggle();
            });

            $(document).on("submit", ".replyForm", function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "../../server/AgregarRespuesta.php",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        alert(response); // Mostrar mensaje de éxito o error
                        var categoria = $("#categoriaInput").val(); // Obtener la categoría seleccionada
                        loadComments(categoria); // Recargar los comentarios después de agregar respuesta
                        $(".replyForm").remove(); // Eliminar el formulario de respuesta después de enviar
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Error al agregar la respuesta. Por favor, inténtalo de nuevo más tarde.");
                    }
                });
            });

            // Envío de comentarios principales
            $("#commentForm").submit(function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "../../server/AgregarComentario.php",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        alert(response); // Mostrar mensaje de éxito o error
                        var categoria = $("#categoriaInput").val(); // Obtener la categoría seleccionada
                        loadComments(categoria); // Recargar los comentarios después de agregar comentario principal
                        $("#commentInput").val(""); // Limpiar el campo de comentario
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Error al agregar el comentario. Por favor, inténtalo de nuevo más tarde.");
                    }
                });
            });

            // Selección de categoría
            $(".categoria-btn").click(function () {
                var categoria = $(this).data("categoria");
                $("#categoriaInput").val(categoria); // Establecer la categoría seleccionada
                loadComments(categoria); // Cargar comentarios de la categoría seleccionada
            });
        });

    </script>
    <script src="script.js"></script>
</body>

</html>