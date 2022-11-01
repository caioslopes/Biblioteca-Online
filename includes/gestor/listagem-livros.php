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
.caixa-btn{
    margin-top: 10px;
    gap: 5px;
}
.caixa-btn a{
    width: 48%;
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
        margin-bottom: 20px
    }
}

</style>
<?php
    //Puxa os dados da tabela livros
    //Monta a query
    $querySelect = $conn->prepare('SELECT * FROM livro');
    //Executa da query
    $querySelect->execute();
    //Pega o resultado da execução da query
    $resultQuery = $querySelect->get_result();

    //Função responsavel por deletar o livro do banco de dados
    if(!empty($_GET['id'])){
        //Pega o id do livro, que foi passado por URL
        $id_livro = $_GET['id'];

        //Define o diretorio das imagens para poder excluir-las
         $pasta = '../img/';

        //Monta a query
        $SelectImagem = $conn->prepare("SELECT * FROM livro WHERE id_livro = ?");
        //Separa o valor do id da query
        $SelectImagem->bind_param("i", $id_livro);
        //Executa da query
        $SelectImagem->execute();
        //Pega o resultado da query
        $NomeImagem = $SelectImagem->get_result();

        //Puxo o nome do arquivo(imagem), para poder exclui-lo junto ao livro.
        while($Imagem = mysqli_fetch_assoc($NomeImagem)){
          $imagem_livro = $Imagem['imagem'];
        };

        //Verifica se a $querySelect teve resultado, se o numero de linhas for maior que 0 (se tiver algum registro), o registro sera deletado.
        if($NomeImagem->num_rows > 0){

          //Monta a query
          $queryDelet = $conn->prepare("DELETE FROM livro WHERE id_livro = ?");
           //Separa o valor do id da query
          $queryDelet->bind_param("i", $id_livro);
           //Executa da query
          $queryDelet->execute();

          //Apaga a imagem da pasta de img
          unlink($pasta.$imagem_livro);
        };

        header('location: livros.php?status=success');

    };

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
            <form class="d-flex" role="search" method="GET">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar um livro" value="<?php if (isset($_GET['busca'])){ echo $_GET['busca']; } ?>">
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
    $sql = $conn->prepare("SELECT * FROM livro LIMIT $inicio, $qnt_result_pg");
    $sql->execute();
    $result = $sql->get_result();

  ?>
  <?php if(empty($_GET['busca'])){?>
      <div class="fundo__vitrine--livros mt-4">
      <section class="container-xl">
        <div class="vitrine">
          <?php while ($livros = mysqli_fetch_assoc($result)) {?>
          <div class="livros">
              <img src='../img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
              <div class="caixa-btn">
                <a class="btn btn-sm btn-primary rounded-pill" href="editar.php?id=<?php echo $livros['id_livro'] ?>">Editar</a>
                <a class="btn btn-sm btn-danger rounded-pill" href="livros.php?id=<?php echo $livros['id_livro'] ?>">Excluir</a>
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
         <!-- Resultado da pesquisa do usuario -->
    <?php
        }else { 
            //Pega o valor digitado pelo usuario na barra de pesquisa
            $busca = $_GET['busca'];    

            //Receber o número da página
            $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
            $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

            //Setar a quantidade de itens por pagina
            $qnt_result_pg = 12;

            //calcular o inicio visualização
            $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;
            $SelectBusca = $conn->prepare("SELECT * FROM livro WHERE titulo LIKE '%$busca%' OR autor LIKE '%$busca%' LIMIT $inicio, $qnt_result_pg");
            $SelectBusca->execute();
            $resultBusca = $SelectBusca->get_result();
        
        if($resultBusca->num_rows == 0){ ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <h4>Nenhum resultado encontrado...</h4>
                        <a class="btn btn-primary" href="livros.php">Livros</a>
                    </section>
                </div>

       <?php  }else { ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="vitrine">
                        <?php while ($livro_busca = mysqli_fetch_assoc($resultBusca)) {?>
                        <div class="livros">
                            <img src='../img/<?php echo $livro_busca['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
                            <div class="caixa-btn">
                                <a class="btn btn-sm btn-primary rounded-pill" href="editar.php?id=<?php echo $livro_busca['id_livro'] ?>">Editar</a>
                                <a class="btn btn-sm btn-danger rounded-pill" href="livros.php?id=<?php echo $livro_busca['id_livro'] ?>">Excluir</a>
                            </div>
                        </div>
                        <?php } ?>
                        </div>  
                    </section>
                </div>
       
   <?php }} ?>
</section>