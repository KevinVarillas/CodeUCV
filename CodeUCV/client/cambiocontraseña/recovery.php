<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css" rel="stylesheet">

    <link rel="stylesheet" href="password.css">
    <title>Document</title>
</head>

<body>
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
            <form action="../../server/php/recovery.php" method="POST" class="sign-in-form">
                <h2 class="title">Recupera tu contraseña</h2>
                <div class="input-field">
                    <i class="ri-mail-fill"></i>
                    <input type="email" name="correo" placeholder="Correo" required>
                </div>
                <input type="submit" value="Recuperar Contraseña" class="btn">
            </form>
            </div>
            </div>


</body>

</html>