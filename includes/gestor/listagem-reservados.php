  <?php

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
    }

?>
<section class="container-xl corpo">

    <?=$msg?>

    <div class="d-flex justify-content-between titulo-pagina">
        <div class="titulo-index">
            <span>Emprestados</span>
        </div>
        <div class="caixa-busca">
            <form class="d-flex" role="search" method="POST" action="pesquisa-reservados.php">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar Registro">
                <button class="btn btn-busca-regis" type="submit">Buscar Registro</button>
            </form>
        </div>
    </div>
    <?php
    //Receber o número da página
    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    //Setar a quantidade de itens por pagina
    $qnt_result_pg = 12;

    //calcular o inicio visualização
    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
    $sql = $conn->prepare("SELECT *,DATE_FORMAT(data_da_reserva,'%d/%m/%Y') 
    AS data_reservaf,
    DATE_FORMAT(data_da_entrega,'%d/%m/%Y')
    AS data_entregaf
     FROM reserva
    INNER JOIN livro
    ON id_livro = reserva.cod_livro
    INNER JOIN aluno
    ON id_aluno = reserva.cod_aluno LIMIT $inicio, $qnt_result_pg");
    $sql->execute();
    $result = $sql->get_result();
    ?>
     <div class="table-livros mt-4">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="mobile-non-display">#</th>
                        <th scope="col">Aluno</th>
                        <th scope="col" class="mobile-non-display">Livro</th>
                        <th scope="col" class="mobile-non-display">Data Reserva</th>
                        <th scope="col" class="mobile-non-display">Data Entrega</th>
                        <th scope="col">Dar Baixa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    /* Retorna num array as informações da função acima */
                    while ($reserva = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td class="mobile-non-display"><?php echo $reserva['id_reserva'] ?></td>
                            <td><?php echo $reserva['nome_aluno'] ?></td>
                            <td class="mobile-non-display"><?php echo $reserva['titulo'] ?></td>
                            <td class="mobile-non-display"><?php echo $reserva['data_reservaf'] ?></td>
                            <td class="mobile-non-display"><?php echo $reserva['data_entregaf'] ?></td>
                            <td>
                                <a href='dar-baixa-livro.php?id=<?php echo $reserva['id_reserva'] ?>' class='btn btn-sm btn-primary'>
                                    Dar Baixa
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
         <?php 
        //Paginção - Somar a quantidade de livro
        $result_pg = $conn->prepare("SELECT COUNT(id_reserva) AS num_result FROM reserva");
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
        <a class='link-pag' href='livros-reservados.php?pagina=1'>Primeira</a>
        <?php
        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if ($pag_ant >= 1) {
                echo "<a class='link-pag' href='livros-reservados.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        } ?>
        <span class='link-pag pag-atual'><?php echo $pagina ?></span>
        <?php
        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
            if ($pag_dep <= $quantidade_pg) { ?>
                <a class='link-pag' href='livros-reservados.php?pagina=<?php echo $pag_dep ?>'><?php echo $pag_dep ?></a> 
        <?php  }
        }

        ?>
        <a class='link-pag' href='livros-reservados.php?pagina=<?php echo $quantidade_pg ?>'>Ultima</a>
        </div>
        </div>
</section>