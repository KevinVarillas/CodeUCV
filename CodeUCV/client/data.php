<?php
session_start();
include_once "../server/config.php";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header("location: iniciosesion/iniciosesion.php");
    exit;
}

include_once "header.php";
?>

<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <div class="content">
                    <?php
                    // Obtener detalles del usuario actual
                    $id = $_SESSION['id'];
                    $sql_user = "SELECT * FROM usuarios WHERE id = ?";
                    $stmt_user = $conn->prepare($sql_user);
                    $stmt_user->bind_param("i", $id);
                    $stmt_user->execute();
                    $result_user = $stmt_user->get_result();

                    if ($result_user->num_rows == 1) {
                        $row_user = $result_user->fetch_assoc();
                        ?>
                        <div class="details">
                            <span><?php echo htmlspecialchars($row_user['nombre_usuario'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <?php
                    } else {
                        echo "Usuario no encontrado";
                    }
                    ?>
                </div>
            </header>

            <div class="users-list">
                <?php
                // Consulta para obtener la lista de usuarios disponibles para chatear
                $sql_users = "SELECT * FROM usuarios WHERE id != ?";
                $stmt_users = $conn->prepare($sql_users);
                $stmt_users->bind_param("i", $id);
                $stmt_users->execute();
                $result_users = $stmt_users->get_result();

                if ($result_users->num_rows > 0) {
                    while ($row_users = $result_users->fetch_assoc()) {
                        // Mostrar cada usuario con su respectivo contenedor de último mensaje
                        echo '<a href="chat.php?user_id=' . $row_users['id'] . '">
                            <div class="content">
                                <img src="../server/php/image.php?id=' . $row_users['id'] . '" alt="Foto de Perfil">
                                <div class="details">
                                    <span>' . htmlspecialchars($row_users['nombre_usuario'], ENT_QUOTES, 'UTF-8') . '</span>';

                        // Consulta para obtener el último mensaje entre el usuario actual y este usuario
                        $sql_last_message = "SELECT * FROM messages WHERE (incoming_msg_id = ? AND outgoing_msg_id = ?) OR (incoming_msg_id = ? AND outgoing_msg_id = ?) ORDER BY msg_id DESC LIMIT 1";
                        $stmt_last_message = $conn->prepare($sql_last_message);
                        $stmt_last_message->bind_param("iiii", $id, $row_users['id'], $row_users['id'], $id);
                        $stmt_last_message->execute();
                        $result_last_message = $stmt_last_message->get_result();

                        // Mostrar el último mensaje
                        if ($result_last_message->num_rows > 0) {
                            $row_last_message = $result_last_message->fetch_assoc();
                            $last_msg = htmlspecialchars($row_last_message['msg'], ENT_QUOTES, 'UTF-8');
                            $short_msg = strlen($last_msg) > 28 ? substr($last_msg, 0, 28) . '...' : $last_msg;

                            // Determinar si el mensaje saliente es del usuario actual
                            if ($row_last_message['outgoing_msg_id'] == $id) {
                                $you = "Tu: ";
                            } else {
                                $you = "";
                            }

                            echo '<p>' . $you . $short_msg . '</p>';
                        } else {
                            echo '<p>No hay mensajes disponibles.</p>';
                        }

                        echo '</div>
                            </div>
                          </a>';
                    }
                } else {
                    echo "No hay usuarios disponibles para chatear.";
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>
