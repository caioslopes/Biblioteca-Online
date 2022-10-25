  <?php

    $msg = '';
    if(isset($_GET['status'])){
        switch ($_GET['status']){
            case 'success';
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Ação executada com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;

            case 'error';
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Ação não executada!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;
        }
    }

?>

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
@media (max-width: 767px){
    .titulo-pagina{
        flex-direction: column;
        align-items: center;
    }
    .caixa-busca{
        width: 90%;
        margin-bottom: 20px
    }
}
</style>

<section class="container-xl corpo">

    <?=$msg?>

    <div class="d-flex justify-content-between titulo-pagina">
        <div>
            <h1>Solicitações de reserva</h1>
        </div>
        <div class="caixa-busca">
            <form class="d-flex" role="search" method="GET">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar aluno/livro" value="<?php if (isset($_GET['busca'])){ echo $_GET['busca']; } ?>">
                <button class="btn btn-outline-primary" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
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
    $sql = $conn->prepare("SELECT * FROM reserva_temp
    INNER JOIN livro
    ON id_livro = reserva_temp.cod_livro
    INNER JOIN aluno
    ON id_aluno = reserva_temp.cod_aluno LIMIT $inicio, $qnt_result_pg");
    $sql->execute();
    $result = $sql->get_result();
    ?>

    <?php if(empty($_GET['busca'])){?>
     <div class="table-livros mt-4">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aluno</th>
                        <th scope="col">Livro</th>
                        <th scope="col">Data Reserva</th>
                        <th scope="col">Data Entrega</th>
                        <th scope="col">Dar Baixa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    /* Retorna num array as informações da função acima */
                    while ($reserva = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $reserva['id_temp'] ?></td>
                            <td><?php echo $reserva['nome_aluno'] ?></td>
                            <td><?php echo $reserva['titulo'] ?></td>
                            <td><?php echo $reserva['data_hoje'] ?></td>
                            <td><?php echo $reserva['data_amanha'] ?></td>
                            <td>
                                <a href='confirmar-reserva-temp.php?id_temp=<?php echo $reserva['id_temp'] ?>' class='btn btn-sm btn-primary'>
                                    Confirmar
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
         <?php 
        //Paginção - Somar a quantidade de livro
        $result_pg = $conn->prepare("SELECT COUNT(id_temp) AS num_result FROM reserva_temp");
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
        <a class='link-pag' href='listagem-reserva-temp.php?pagina=1'>Primeira</a>
        <?php
        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if ($pag_ant >= 1) {
                echo "<a class='link-pag' href='listagem-reserva-temp.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        } ?>
        <span class='link-pag pag-atual'><?php echo $pagina ?></span>
        <?php
        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
            if ($pag_dep <= $quantidade_pg) { ?>
                <a class='link-pag' href='listagem-reserva-temp.php?pagina=<?php echo $pag_dep ?>'><?php echo $pag_dep ?></a> 
        <?php  }
        }

        ?>
        <a class='link-pag' href='listagem-reserva-temp.php?pagina=<?php echo $quantidade_pg ?>'>Ultima</a>
        </div>
        </div>
         <!-- Resultado da pesquisa do usuario -->
    <?php
        }else { 
            //Pega o valor digitado pelo usuario na barra de pesquisa
            $busca = $_GET['busca'];    

            $SelectBusca = $conn->prepare("SELECT * FROM reserva_temp
            INNER JOIN livro
            ON id_livro = reserva_temp.cod_livro 
            INNER JOIN aluno
            ON id_aluno = reserva_temp.cod_aluno 
            WHERE nome_aluno LIKE '%$busca%' OR titulo LIKE '%$busca%'");
            $SelectBusca->execute();
            $resultBusca = $SelectBusca->get_result();
        
        if($resultBusca->num_rows == 0){ ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <h4>Nenhum resultado encontrado...</h4>
                        <a class="btn btn-primary" href="listagem-reserva-temp.php">Livros emprestados</a>
                    </section>
                </div>

       <?php  }else { ?>
                 <div class="table-livros mt-4">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Aluno</th>
                                <th scope="col">Livro</th>
                                <th scope="col">Data Reserva</th>
                                <th scope="col">Data Entrega</th>
                                <th scope="col">Dar Baixa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* Retorna num array as informações da função acima */
                            while ($reserva = mysqli_fetch_assoc($resultBusca)) {
                            ?>
                                <tr>
                                    <td><?php echo $reserva['id_temp'] ?></td>
                                    <td><?php echo $reserva['nome_aluno'] ?></td>
                                    <td><?php echo $reserva['titulo'] ?></td>
                                    <td><?php echo $reserva['data_hoje'] ?></td>
                                    <td><?php echo $reserva['data_amanha'] ?></td>
                                    <td>
                                        <a href='confirmar-reserva-temp.php?id_temp=<?php echo $reserva['id_temp'] ?>' class='btn btn-sm btn-primary'>
                                            Confirmar
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
       
   <?php }} ?>
</section>