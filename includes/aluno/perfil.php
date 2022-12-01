<?php

    //Consulta Livros na tabela reserva (Reserva Efetivada)
    $consulta_livros = $conn->prepare("SELECT livro.*, reserva.*, DATE_FORMAT(data_da_reserva,'%d/%m/%Y') 
    AS data_reservaf,
    DATE_FORMAT(data_da_entrega,'%d/%m/%Y')
    AS data_entregaf
        FROM reserva 
        LEFT JOIN livro
        ON livro.id_livro = reserva.cod_livro
        WHERE reserva.cod_aluno = $id_aluno");
    $consulta_livros->execute();
    $result_consulta = $consulta_livros->get_result();

    //Consulta Livros na tabela reserva_temp (Auto reserva)
    $sqlTemp = $conn->prepare("SELECT livro.*, DATE_FORMAT(data_hoje,'%d/%m/%Y') 
    AS data_hojef,DATE_FORMAT(data_amanha,'%d/%m/%Y')
    AS data_amanhaf, reserva_temp.* 
        FROM reserva_temp
        LEFT JOIN livro
        ON livro.id_livro = reserva_temp.cod_livro
        WHERE reserva_temp.cod_aluno = $id_aluno");
    $sqlTemp->execute();
    $resultSqlTemp = $sqlTemp->get_result();

    //Função que deleta a reserva temporaria feita pelo aluno
    if(!empty($_GET['id_temp'])){
        $id_temp = $_GET['id_temp'];
        
        foreach($resultSqlTemp as $temp){
            $id_livro_temp = $temp['cod_livro'];
        };

        $sqlSelect = $conn->prepare("SELECT * FROM reserva_temp WHERE id_temp = $id_temp");
        $sqlSelect->execute();
        $result = $sqlSelect->get_result();

        /* Função que relaciona as tabelas livro e reserva, fazendo uma conta de subtração para retornar quantos livros estão disponiveis */
        $querySelectLivro = $conn->prepare("SELECT * FROM livro  WHERE id_livro = $id_livro_temp");
        $querySelectLivro->execute();
        $resultQueryLivro = $querySelectLivro->get_result();

        if ($result->num_rows > 0){

            while($queryQuantidade = mysqli_fetch_assoc($resultQueryLivro)){
            $qtd_total = $queryQuantidade['qtd_total'];
            $qtd_reserva = $queryQuantidade['qtd_reserva'];
            $qtd_temp = $queryQuantidade['qtd_temp'];
            };

            if($qtd_temp <= 0){
                header('location: perfil.php?status=error');    
            }else{
            $sqlDelete = $conn->prepare("DELETE FROM reserva_temp WHERE id_temp = $id_temp");
            $sqlDelete->execute();

            $sqlUpdateReserva = $conn->prepare("UPDATE livro SET qtd_temp = qtd_temp -1 WHERE id_livro = $id_livro_temp");
            $sqlUpdateReserva->execute();
            header('location: perfil.php?status=success');
            exit;
            }
        }
    };

    $msg = '';
    if(isset($_GET['status'])){
        switch ($_GET['status']){
            case 'success';
            $msg = '<div class="alert alert-success alert-dismissible fade show alerta-personalizado" role="alert">
                        Ação executada com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;

            case 'error';
            $msg = '<div class="alert alert-danger alert-dismissible fade show alerta-personalizado" role="alert">
                        Ação não executada!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;
        }
    };
?>
<section class="container-xl mt-4 corpo">

    <!-- Alerta de status ação -->
    <?=$msg?>

            <div class="titulo-index">
                <span>Perfil</span>
            </div>

  <div class="card__aluno">
            <div class="card__aluno--topo">
                <div class="card__aluno--linha">
                    <div class="card__aluno--coluna">
                        <span>Nome</span>
                        <span><?php echo $nome_aluno ?></span>
                    </div>
                </div>

                <div class="card__aluno--linha">
                    <div class="card__aluno--coluna">
                        <span>Email</span>
                        <span><?php echo  $email_aluno ?></span>
                    </div>
                </div>
            </div>
    
    <?php if ($result_consulta->num_rows <= 0  && $resultSqlTemp->num_rows <= 0) { ?>
                <div class="card__aluno--corpo">
                    <div>
                        <h4>Seus Livros</h4>
                    </div>

                    <div>
                        <h6>Você não possui nenhum livro reservado</h6>
                    </div>
                </div>
                <?php } else if($result_consulta->num_rows >= 1) {

                while ($livros = mysqli_fetch_assoc($result_consulta)) {
                ?>
                    <div class="card__aluno--corpo">
                        <div>
                            <h4>Seus Livros</h4>
                        </div>

                        <div class="card__aluno--linha">
                            <div class="card__aluno--livro">
                                <img src="../img/<?php echo $livros['imagem'] ?>" alt="">
                                <div class="card__aluno--livro--texto">
                                    <span><?php echo $livros['titulo'] ?></span>
                                    <span><?php echo $livros['autor'] ?></span>
                                </div>
                            </div>

                            <div class="caixa-datas">
                                <div class="card__aluno--datas">
                                    <span>Data efetiva da reserva:</span>
                                    <span class="data__"><?php echo $livros['data_reservaf'] ?></span>
                                </div>
                                <div class="card__aluno--datas">
                                    <span>Data de entrega do livro:</span>
                                    <span class="data__"><?php echo $livros['data_entregaf'] ?></span>
                                </div>
                            </div>

                        </div>

                    </div>
            <?php }}else if($resultSqlTemp->num_rows >= 1){ ?>  
            <?php while ($dados_temp = mysqli_fetch_assoc($resultSqlTemp)) { ?>
                <div class="card__aluno--corpo">
                    <div class="d-flex justify-content-between">
                        <h4>Reservas Temporarias</h4>
                    </div>
                    <div class="card__aluno--linha">
                        <div class="card__aluno--livro">
                            <img src="../img/<?php echo $dados_temp['imagem'] ?>" alt="">
                            <div class="card__aluno--livro--texto">
                                <span><?php echo $dados_temp['titulo'] ?></span>
                                <span><?php echo $dados_temp['autor'] ?></span>
                            </div>
                        </div>

                        <div class="caixa-datas">
                            <div class="card__aluno--datas">
                                <span>Data do pedido de reserva:</span>
                                <span class="data__"><?php echo $dados_temp['data_hojef'] ?></span>
                            </div>
                            <div class="card__aluno--datas">
                                <span>Data para confirmar a reserva:</span>
                                <span class="data__"><?php echo $dados_temp['data_amanhaf'] ?></span>
                            </div>
                        </div> 
                    </div>
                    <div class="caixa-btn-cancelar-reserva">
                        <a class="btn btn-danger" href="perfil.php?id_temp=<?php echo $dados_temp['id_temp'] ?>">Cancelar reserva</a>
                    </div>
                </div>
            <?php }} ?>       
</section>