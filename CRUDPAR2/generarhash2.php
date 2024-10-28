<?php
// Cambia 'tu_contraseña' a la contraseña que deseas usar
$password = 'tayson';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo $hashedPassword;
?>
