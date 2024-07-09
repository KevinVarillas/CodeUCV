<?php 
session_start();
if(isset($_SESSION['id'])){
    include_once "config.php";
    $outgoing_id = $_SESSION['id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    if(!empty($message)){
        $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')";

        $query = mysqli_query($conn, $sql);
        
        if($query){
            echo "Mensaje enviado";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Los mensajes están vacios";
    }
} else {
    header("location: ../../client/iniciosesion/iniciosesion.php");
}
?>