<!-- Conteudo que mostrara os livros cadastrados no sistema -->
<style>
  .vitrine {
   display: grid;
    grid-template-columns: repeat(6, 176px);
    gap: 25px 40px;
    margin-top: 20px;
    margin-bottom: 30px;
    padding-top: 20px;
    padding-bottom: 20px;
}

.vitrine div {
    flex: 1 1 200px;
    flex-wrap: wrap;
}

.capa-livros {
    width: 100%;
    height: 250px;
    border: 3px solid;
    border-radius: 10px;
}

.vitrine__livros--texto{
  margin-top: 5px;
}

/* Paginação */
.link-pag {
    color: #23232e;
    border: 1px solid #23232e;
    padding: 10px;
    margin-left: 5px;
    border-radius: 30px;
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
.caixa-btn{
    margin-top: 10px;
    gap: 5px;
}
.caixa-btn a{
    width: 48%;
}
.caixa-titulo{
    min-height: 50px;
}
.pesquisa-sem-result{
    gap: 10px;
}
.caixa-busca{
    display: flex;
    justify-content: center;
    gap: 70px;
}
.caixa-categoria span{
    margin-right: 10px;
}
@media (max-width: 767px){
    .vitrine{
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        padding-bottom: 20px;
    }
    .titulo-pagina{
        flex-direction: column;
        align-items: center;
    }
    .caixa-busca{
        width: 90%;
        margin-bottom: 20px;
        flex-direction: column;
        gap: 30px;
    }
    .caixa-categoria{
        order: 1;
    }
}

</style>
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

            case 'erro';
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Ação não executada!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;
        }
    }
?>


<section class="container-xl mt-3 corpo">

<?=$msg?>

 <div class="d-flex justify-content-between titulo-pagina">
        <div>
            <h1>Livros Disponiveis</h1>
        </div>
        <div class="caixa-busca">
            <div class="caixa-categoria">
                <span>Buscar por</span>
                <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    Categoria
                </button>
                <ul class="dropdown-menu">
                    <?php 
                        $SelectCategoria = $conn->prepare("SELECT * FROM categoria");
                        $SelectCategoria->execute();
                        $resultCategoria = $SelectCategoria->get_result(); ?>

                    <li><a class="dropdown-item" href="livros.php">Todos os Livros</a></li>

                     <?php   while($dados = mysqli_fetch_assoc($resultCategoria)){ ?>
                            <li><a class="dropdown-item" href="categorias.php?id_categoria=<?php echo $dados['id_categoria']; ?>"><?php echo $dados['nome_categoria']; ?></a></li>
                      <?php  } ?>
                </ul>
                </div>
            </div>

            <form class="d-flex" role="search" method="POST" action="pesquisa-livros.php">
                <input class="form-control me-2 rounded-pill" type="search" name="busca" placeholder="Buscar um livro">
                <button class="btn btn-outline-primary rounded-circle" type="submit">
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
    $sql = $conn->prepare("SELECT * FROM livro LIMIT $inicio, $qnt_result_pg");
    $sql->execute();
    $result = $sql->get_result();

  ?>
      <div class="fundo__vitrine--livros mt-4">
      <section class="container-xl">
        <div class="vitrine">
          <?php while ($livros = mysqli_fetch_assoc($result)) {?>
          <div class="livros">
              <img src='../img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
              <div class="caixa-btn">
                    <div class="caixa-titulo">
                        <span><?php echo $livros['titulo'] ?></span>
                    </div>
                    <a class="btn btn-sm btn-primary rounded-pill" href="editar.php?id=<?php echo $livros['id_livro'] ?>">Editar</a>
                    <a class="btn btn-sm btn-danger rounded-pill" href="confirmacao-exclusao.php?id=<?php echo $livros['id_livro'] ?>">Excluir</a>
                </div>
          </div>
          <?php } ?>
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