<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'etec');
define('BASE', 'biblioteca');

$conn = new mysqli(HOST, USER, PASS, BASE);

if ($conn->connect_error) {
    printf('Erro de conexão: %s', $conn->connect_errno);
    exit;
}

/*
 * compatibilidade para to 5.2.9 e 5.3.0.
 */
if (mysqli_connect_error()) {
    printf('Erro de conexão: %s', mysqli_connect_error());
    exit;
}

if (false === $conn->set_charset('utf8')) {
    printf('Error ao usar utf8: %s', $conn->error);
    exit;
}