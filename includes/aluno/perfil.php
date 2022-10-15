<style>
  /* Pagina do aluno */
.card__aluno--linha {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.card__aluno--coluna {
    display: flex;
    flex-direction: column;
}

.card__aluno {
    margin-top: 30px;
}

.card__aluno--topo {
    background-color: #23232e;
    color: white;
    padding: 20px 20px;
    border-radius: 10px 10px 0px 0px;
}

.card__aluno--corpo {
    background-color: #e9ecef;
    border: 1px solid;
    padding: 20px;
    border-radius: 0px 0px 10px 10px;
}

.card__aluno--livro {
    display: flex;
}

.card__aluno--livro img {
    width: 150px;
}

.card__aluno--livro--texto {
    margin-left: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card__aluno--datas {
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
}
</style>

<?php

    $consulta_livros = $conn->prepare("SELECT livro.imagem, livro.id_livro, livro.titulo, livro.autor, reserva.* 
    FROM reserva 
    LEFT JOIN livro
    ON livro.id_livro = reserva.cod_livro
    WHERE reserva.cod_aluno = $id_aluno");
    $consulta_livros->execute();
    $result_consulta = $consulta_livros->get_result();

?>

<section class="container-xl mt-4 corpo">
   <div class="titulo-pagina">
    <h1>Perfil</h1>
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
                        <?php

            if ($result_consulta->num_rows <= 0) { ?>
                <div class="card__aluno--corpo">
                    <div>
                        <h4>Seus Livros</h4>
                    </div>

                    <div>
                        <h6>Você não possui nenhum livro reservado</h6>
                    </div>
                </div>
                <?php } else {

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

                            <div class="card__aluno--datas">
                                <div class="card__aluno--datas">
                                    <span>Data efetiva da reserva:</span>
                                    <span class="data__"><?php echo $livros['data_da_reserva'] ?></span>
                                </div>
                                <div class="card__aluno--datas">
                                    <span>Data de entrega do livro:</span>
                                    <span class="data__"><?php echo $livros['data_da_entrega'] ?></span>
                                </div>
                            </div>

                        </div>

                    </div>
            <?php }
            } ?>
</section>