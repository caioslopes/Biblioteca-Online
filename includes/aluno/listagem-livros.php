<!-- Conteudo que mostrara os livros cadastrados no sistema -->
<section class="container-xl corpo mt-100px">

    <div class="d-flex justify-content-between titulo-pagina">
            <div class="titulo-index">
                <span>Todos Os Livros</span>
            </div>
        <div class="caixa-busca">
        <div class="caixa-categoria">
                <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle btn-padrao" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    Todos os livros
                </button>
                <ul class="dropdown-menu">
                    <?php 
                        $SelectCategoria = $conn->prepare("SELECT * FROM categoria");
                        $SelectCategoria->execute();
                        $resultCategoria = $SelectCategoria->get_result(); ?>

                    <li><a class="dropdown-item" href="livros.php">Todos os Livros</a></li>

                    <?php while($dados = mysqli_fetch_assoc($resultCategoria)){ ?>
                            <li><a class="dropdown-item" href="categorias.php?id_categoria=<?php echo $dados['id_categoria']; ?>"><?php echo $dados['nome_categoria']; ?></a></li>
                      <?php  } ?>
                </ul>
                </div>
            </div>

            <form class="d-flex" role="search" method="POST" action="pesquisa-livros.php">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar um livro" value="<?php if (isset($_POST['busca'])){ echo $_POST['busca']; } ?>">
                <button class="btn btn-busca" type="submit">Buscar Livro</button>
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
    $sql = $conn->prepare("SELECT * FROM livro LIMIT $inicio, $qnt_result_pg");
    $sql->execute();
    $result = $sql->get_result();

    //Consulta a tabela reserva_temp e reserva para verificar se o aluno pode ou não reservar novo livro
    $reserva_temp = $conn->prepare("SELECT cod_aluno FROM reserva_temp WHERE cod_aluno = $id_aluno");
    $reserva_temp->execute();
    $resultReserva_temp = $reserva_temp->get_result();

    //Consulta a tabela reserva e reserva para verificar se o aluno pode ou não reservar novo livro
    $reserva = $conn->prepare("SELECT cod_aluno FROM reserva WHERE cod_aluno = $id_aluno");
    $reserva->execute();
    $resultreserva = $reserva->get_result();



  ?>
      <div class="fundo__vitrine--livros mt-4">
      <section class="container-xl">
        <div class="vitrine">
          <?php while ($livros = mysqli_fetch_assoc($result)) {?>
            <div class="livros">
                <a class="livro-link" href="pagina-interna-livros.php?id_livro=<?php echo $livros['id_livro'] ?>">
                <img src='../img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
                <div class="vitrine__livros--texto">
                    <div class="caixa-titulo">
                        <span><?php echo $livros['titulo'] ?></span>
                    </div>
                </a>
            </div> 
          </div>
          <?php }; ?>
        </div>
      </section>
      </div>
      <?php 
        //Paginção - Somar a quantidade de livro
        $result_pg = $conn->prepare("SELECT COUNT(id_livro) AS num_result FROM livro");
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
        <a class='link-pag' href='livros.php?pagina=1'>Primeira</a>
        <?php
        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if ($pag_ant >= 1) {
                echo "<a class='link-pag' href='livros.php?pagina=$pag_ant'>$pag_ant</a> ";
            }
        } ?>
        <span class='link-pag pag-atual'><?php echo $pagina ?></span>
        <?php
        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
            if ($pag_dep <= $quantidade_pg) { ?>
                <a class='link-pag' href='livros.php?pagina=<?php echo $pag_dep ?>'><?php echo $pag_dep ?></a> 
        <?php  }
        }

        ?>
        <a class='link-pag' href='livros.php?pagina=<?php echo $quantidade_pg ?>'>Ultima</a>
        </div>
        </div>
</section>