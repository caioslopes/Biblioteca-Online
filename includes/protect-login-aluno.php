<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_aluno'])) {
    die("Você não pode acessar esta página porque não está logado.<p><a class=\"btn btn-primary\" href=\"../index.php\">Voltar para a página inicial</a></p>");
}
