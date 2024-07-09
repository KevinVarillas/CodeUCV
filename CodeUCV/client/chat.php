<?php 
session_start();
include_once "../server/config.php";

// Redireccionar al inicio de sesión si no hay sesión activa
if(!isset($_SESSION['id'])){
  header("location: iniciosesion/iniciosesion.php");
  exit; // Asegurarse de que el script termine después de redirigir
}

include_once "header.php"; 
?>

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

          // Consulta para obtener los detalles del usuario
          $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
          $stmt->bind_param("i", $user_id);
          $stmt->execute();
          $result = $stmt->get_result();

          if($result->num_rows > 0){
            $row = $result->fetch_assoc();
          } else {
            header("location: users.php"); // Redireccionar si no se encuentra el usuario
            exit;
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        
        <div class="details">
          <span><?php echo $row['nombre_usuario']; ?></span>
         
        </div>
      </header>
      <div class="chat-box">
        <!-- Aquí se mostrarán los mensajes -->
      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Escribe algo..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="../server/javascript/chat.js"></script>

</body>
</html>