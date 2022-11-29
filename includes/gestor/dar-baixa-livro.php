<?php


if (!empty($_GET['id'])) {

    $id = $_GET['id'];

    $sqlSelect = $conn->prepare("SELECT * FROM reserva WHERE id_reserva = $id");
    $sqlSelect->execute();
    $result = $sqlSelect->get_result();

    foreach($result as $reserva){
        $id_livro = $reserva['cod_livro'];
        $cod_aluno = $reserva['cod_aluno'];
        $data_da_reserva = $reserva['data_da_reserva'];
    }


    if ($result->num_rows > 0) {

            /* Função que relaciona as tabelas livro e reserva, fazendo uma conta de subtração para retornar quantos livros estão disponiveis */
            $querySelectLivro = $conn->prepare("SELECT * FROM livro  WHERE id_livro = $id_livro");
            $querySelectLivro->execute();
            $resultQueryLivro = $querySelectLivro->get_result();

            //Puxa os dados da relação da tabela livro com a tabela reserva para poderos saber a conta de quantos livros estão disponiveis
            while($queryQuantidade = mysqli_fetch_assoc($resultQueryLivro)){
                $qtd_total = $queryQuantidade['qtd_total'];
                $qtd_reserva = $queryQuantidade['qtd_reserva'];
                $qtd_temp = $queryQuantidade['qtd_temp'];
            };

            if($qtd_reserva <= 0){
                header('location: livros-reservados.php?status=error');
            }else{
                $sqlDelete = "DELETE FROM reserva WHERE id_reserva = $id";
                $resultDelete = $conn->query($sqlDelete);
        
                $sqlUpdateReserva = $conn->prepare("UPDATE livro SET qtd_reserva = qtd_reserva -1 WHERE id_livro = $id_livro");
                $sqlUpdateReserva->execute();

                //Inserindo na tabela registro os dados enviado pelo gestor (historico de informação)
                $queryInsertRegistro = $conn->prepare("INSERT INTO registro (cod_aluno, cod_livro, data_da_reserva, data_da_entrega) VALUES (?, ?, ?, now())");
                $queryInsertRegistro->bind_param("iis", $cod_aluno, $id_livro, $data_da_reserva);
                $queryInsertRegistro->execute();

                header('location: livros-reservados.php?status=success');
                exit;
            }
    }
}
