<?php
session_start();
include_once "config.php";

if(isset($_SESSION['id'])){
    $outgoing_id = $_SESSION['id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";

    $sql = "SELECT messages.msg, messages.outgoing_msg_id, messages.incoming_msg_id,
                   sender.nombre_usuario AS outgoing_username,
                   receiver.nombre_usuario AS incoming_username
            FROM messages
            LEFT JOIN usuarios AS sender ON sender.id = messages.outgoing_msg_id
            LEFT JOIN usuarios AS receiver ON receiver.id = messages.incoming_msg_id
            WHERE (messages.outgoing_msg_id = {$outgoing_id} AND messages.incoming_msg_id = {$incoming_id})
               OR (messages.outgoing_msg_id = {$incoming_id} AND messages.incoming_msg_id = {$outgoing_id})
            ORDER BY messages.msg_id";

    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            if($row['outgoing_msg_id'] == $outgoing_id){
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">No hay mensajes disponibles.</div>';
    }

    echo $output;
} else {
    header("location: ../../client/iniciosesion/iniciosesion.php");
}
?>