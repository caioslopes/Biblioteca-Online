<?php


if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $sqlSelect = $conn->prepare("SELECT * FROM reserva WHERE id_reserva = $id");
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();


    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM reserva WHERE id_reserva = $id";
        $resultDelete = $conn->query($sqlDelete);
    }
}
header('location: livros-reservados.php?=status=sucess');
