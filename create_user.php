<?php

require 'includes/config/database.php';
$db = conectarDB();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-left">
                <h2 class="welcome-message">Se parte de nuestra familia Noma</h2>
            </div>
            <div class="register-right">
                <h1 class="register-title">Crear Usuario</h1>
                <?php
                $username = $password = $confirm_password = "";
                $username_err = $password_err = $confirm_password_err = "";

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Validar nombre de usuario
                    if (empty(trim($_POST["username"]))) {
                        $username_err = "Por favor ingrese un nombre de usuario.";
                    } else {
                        $username = trim($_POST["username"]);
                    }

                    // Validar contraseña
                    if (empty(trim($_POST["password"]))) {
                        $password_err = "Por favor ingrese una contraseña.";
                    } elseif (strlen(trim($_POST["password"])) > 8 || !preg_match('/\d/', trim($_POST["password"]))) {
                        $password_err = "La contraseña debe tener menos de 8 caracteres y contener al menos un número.";
                    } else {
                        $password = trim($_POST["password"]);
                    }

                    // Validar confirmación de contraseña
                    if (empty(trim($_POST["confirm_password"]))) {
                        $confirm_password_err = "Por favor confirme la contraseña.";
                    } else {
                        $confirm_password = trim($_POST["confirm_password"]);
                        if (empty($password_err) && ($password != $confirm_password)) {
                            $confirm_password_err = "Las contraseñas no coinciden.";
                        }
                    }

                    // Verificar errores antes de insertar en la base de datos
                    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        $sql = "INSERT INTO usuarios (usuario, password) VALUES ('$username', '$hashed_password')";
                        if (mysqli_query($db, $sql)) {
                            echo "Usuario creado exitosamente.";
                        } else {
                            echo "Algo salió mal. Por favor, inténtelo de nuevo.";
                        }
                    }
                }
                ?>
                <form class="register-form" id="createUserForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <label for="confirm_password">Confirmar Contraseña</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <button type="submit" class="login-button">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>