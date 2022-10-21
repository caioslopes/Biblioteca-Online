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

 <div class="titulo-pagina">
    <h1>Livros Cadastrados</h1>
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
              <div class="vitrine__livros--texto">
                <!-- <span><?php echo $livros['titulo'] ?></span> -->
              </div>
              <div>
                <a class="btn btn-sm btn-primary" href="editar.php?id=<?php echo $livros['id_livro'] ?>">Editar</a>
                <a class="btn btn-sm btn-danger" href="livros.php?id=<?php echo $livros['id_livro'] ?>">Excluir</a>
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