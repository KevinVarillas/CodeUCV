<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css" rel="stylesheet">

  <link rel="stylesheet" href="password.css">
  <title>Document</title>
</head>

<body >
<div class="box">
        <ul>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>


    </div>
    
    <div class="container">
    <div class="signin-signup">

  <form action="../../server/php/change_password.php" method="POST">
    <h2 class="title">Ingresa la nueva contraseña</h2>
    <div class="input-field">
    <i class="ri-lock-password-fill"></i>
      <input type="password" class="form-control" id="floatingInput" name="new_password">
      <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
      <label for="floatingInput"></label>
    </div>
    <input type="submit" value="Recuperar Contraseña" class="btn">
  </form>
  </div>

</div>

    
  </body>
</html>