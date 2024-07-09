

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="iniciosesion.css">
    <title>Iniciar Sesión</title>
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
¿    <div class="container">
        <div class="signin-signup">
            <form action="../../server/php/login_usuario_be.php" method="POST" class="sign-in-form">
                <h2 class="title">Inicia Sesión</h2>
                <div class="input-field">
                    <i class="ri-mail-fill"></i>
                    <input type="email" name="correo" id="email_signin" placeholder="Correo" required>
                </div>
                <div class="input-field">
                    <i class="ri-lock-password-fill"></i>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </div>
                <div class="remenber-forgot">
                    <a href="../cambiocontraseña/recovery.php"> ¿Olvidaste tu contraseña? </a>
                </div>
                
                <?php if (isset($_GET['message'])) { ?>
                <div class="alert alert-primary" role="alert">
                    <?php
                        switch ($_GET['message']) {
                            case 'ok':
                                echo 'Te llegó un mensaje al correo';
                                break;
                            case 'success_password':
                                echo 'Inicia sesión con tu nueva contraseña';
                                break;
                            default:
                                echo 'Algo salió mal, intenta de nuevo';
                                break;
                        }
                    ?>
                </div>
                <?php } ?>
                
                <div class="error-message" id="error-message-signin"></div>
                
                <input type="submit" value="Iniciar Sesión" class="btn">
                
                <p class="account-text"> ¿No tienes una cuenta? <a href="#" id="sign-up-btn2">Registrarme</a></p>
            </form>
            <form action="../../server/php/registro_usuario_be.php" method="POST" class="sign-up-form">
                <h2 class="title">Regístrate</h2>
                <div class="input-field">
                    <i class="ri-user-fill"></i>
                    <input type="text" name="nombre_usuario" placeholder="Usuario" required>
                </div>
                <div class="input-field">
                    <i class="ri-mail-fill"></i>
                    <input type="email" name="correo" id="email_signup" placeholder="Email" required>
                </div>
                <div class="input-field">
                    <i class="ri-lock-password-fill"></i>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                </div>
                <div class="input-field">
                <i class="ri-user-fill"></i>
                <input type="text" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="input-field">
                <i class="ri-user-fill"></i>
                <input type="text" name="apellido" placeholder="Apellidos" required>
                </div>
                
                <div class="error-message" id="error-message-signup"></div>
                
                <input type="submit" value="Registrar" class="btn">
                <p class="account-text">Ya tengo una cuenta<a href="#" id="sign-in-btn2">Iniciar Sesión</a></p>
            </form>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>¿Miembro de UCVCode?</h3>
                    <p>Si ya formas parte de esta gran familia programadora, ingresa iniciando sesión con tus datos u
                        cuentas de otras plataformas</p>
                    <button class="btn" id="sign-in-btn">Iniciar Sesión</button>
                </div>
                <img src="../img/signin.svg" alt="" class="image">
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>¿Nuevo en UCVCode?</h3>
                    <p> Eres nuevo en esta familia y quieres sumergirte al mundo de la programación, este es tu lugar y
                        tu mundo, regístrate con tus datos u cuentas de otra plataforma. Bienvenido!</p>
                    <button class="btn" id="sign-up-btn">Registrarme</button>
                </div>
                <img src="../img/signup.svg" alt="" class="image">
            </div>
        </div>
    </div>
    <script src="iniciosesion.js"></script>
</body>

</html>
