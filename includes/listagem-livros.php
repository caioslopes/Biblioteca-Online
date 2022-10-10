<!-- Conteudo que mostrara os livros cadastrados no sistema -->

<?php
    //Puxa os dados da tabela livros
    //Monta a query
    $querySelect = $conn->prepare('SELECT * FROM livro');
    //Executa da query
    $querySelect->execute();
    //Pega o resultado da execução da query
    $resultQuery = $querySelect->get_result();

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
      </tr>
    </thead>
    <tbody>
      <!-- Pega os resultados da $resultQuery e joga num laço de repetição (Para mostrar os valores ao usuario)-->
      <?php while($livro= mysqli_fetch_assoc($resultQuery)){?>
          <tr>
            <td><?php echo $livro['id_livro'] ?></td>
            <td><?php echo $livro['cod_livro'] ?></td>
            <td><img style="width: 100px;" src="img/<?php echo $livro['imagem'] ?>"/></td>
            <td><?php echo $livro['titulo'] ?></td>
            <td><?php echo $livro['autor'] ?></td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
</section>