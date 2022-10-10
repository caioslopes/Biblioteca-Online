<!-- Conteudo que mostrara os livros cadastrados no sistema -->

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

        header('location: home.php?=status=success');

    }
?>


<section class="container-xl mt-3">

  <h1>Livros Cadastrados No Sistema</h1>

  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <td>#</td>
        <td>Codigo</td>
        <td>Imagem</td>
        <td>Titulo</td>
        <td>Autor</td>
        <td>Ações</td>
      </tr>
    </thead>
    <tbody>
      <!-- Pega os resultados da $resultQuery e joga num laço de repetição (Para mostrar os valores ao usuario)-->
      <?php while($livro= mysqli_fetch_assoc($resultQuery)){?>
          <tr>
            <td><?php echo $livro['id_livro'] ?></td>
            <td><?php echo $livro['cod_livro'] ?></td>
            <td><img style="width: 100px;" src="../img/<?php echo $livro['imagem'] ?>"/></td>
            <td><?php echo $livro['titulo'] ?></td>
            <td><?php echo $livro['autor'] ?></td>
            <td>
              <div>
                <!-- Botão que leva a pagina editar.php para editar as informações do livro -->
                <a href="editar.php?id=<?php echo $livro['id_livro'] ?>"> <button class="btn btn-primary" >Editar</button> </a>
              </div>
              <div>
                <!-- Botão que excluir o livro -->
                <a href="home.php?id=<?php echo $livro['id_livro'] ?>"> <button class="btn btn-danger">Excluir</button> </a>
              </div>
            </td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
</section>