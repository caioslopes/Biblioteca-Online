<style>
    /* Paginação */
.link-pag {
    color: #23232e;
    border: 1px solid #23232e;
    padding: 10px;
    margin-left: 5px;
    border-radius: 10px;
}      

.link-pag:hover {
    background-color: #23232e;
    color: white;
}

.pag-atual {
    background-color: #23232e;
    color: white;
}

.caixa-pag {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.caixa-pag-num {
    display: flex;
    justify-content: space-between;
}
</style>
<section class="container-xl corpo">

    <div class="titulo-pagina">
        <h1>Registros</h1>
    </div>
     <?php
    //Receber o número da página
    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    //Setar a quantidade de itens por pagina
    $qnt_result_pg = 12;

    //calcular o inicio visualização
    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;  
    $sql = $conn->prepare("SELECT aluno.id_aluno, aluno.nome_aluno, livro.id_livro, livro.titulo, registro.* 
    FROM registro 
    LEFT JOIN aluno
    ON registro.cod_aluno = aluno.id_aluno
    LEFT JOIN livro
    ON registro.cod_livro = livro.id_livro LIMIT $inicio, $qnt_result_pg");
    $sql->execute();
    $result = $sql->get_result();
    ?>

     <div class="table-livros mt-4">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aluno</th>
                        <th scope="col">Livro</th>
                        <th scope="col">Data Reserva</th>
                        <th scope="col">Data Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    /* Retorna num array as informações da função acima */
                    while ($registro = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $registro['id_registro'] ?></td>
                            <td><?php echo $registro['nome_aluno'] ?></td>
                            <td><?php echo $registro['titulo'] ?></td>
                            <td><?php echo $registro['data_da_reserva'] ?></td>
                            <td><?php echo $registro['data_da_entrega'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
          <?php 
        //Paginção - Somar a quantidade de livro
        $result_pg = $conn->prepare("SELECT COUNT(id_registro) AS num_result FROM registro");
        $result_pg->execute();
        $resultado_pg = $result_pg->get_result();

        $row_pg = mysqli_fetch_assoc($resultado_pg);
        //Quantidade de pagina 
        $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

        //Limitar os link antes depois
        $max_links = 2;

        ?>
       <div class='content caixa-pag'>
       <div class='caixa-pag-num'>
        <a class='link-pag' href='registros-reservados.php?pagina=1'>Primeira</a>
        <?php
        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if ($pag_ant >= 1) {
                echo "<a class='link-pag' href='registros-reservados.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        } ?>
        <span class='link-pag pag-atual'><?php echo $pagina ?></span>
        <?php
        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
            if ($pag_dep <= $quantidade_pg) { ?>
                <a class='link-pag' href='registros-reservados.php?pagina=<?php echo $pag_dep ?>'><?php echo $pag_dep ?></a> 
        <?php  }
        }

        ?>
        <a class='link-pag' href='registros-reservados.php?pagina=<?php echo $quantidade_pg ?>'>Ultima</a>
        </div>
        </div>
</section>