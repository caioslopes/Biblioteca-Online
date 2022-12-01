<!-- Abrindo codigo php -->
<?php 

  //Função para selecionar dados categoria
  $querySelect = $conn->prepare("SELECT * FROM categoria");
  $querySelect->execute();
  $resultQuery = $querySelect->get_result();


// verifica se foi enviado um arquivo
if (isset($_FILES['arquivo']['name']) && $_FILES['arquivo']['error'] == 0) {
    /* echo 'Você enviou o arquivo: <strong>' . $_FILES[ 'arquivo' ][ 'name' ] . '</strong><br />';
  echo 'Este arquivo é do tipo: <strong > ' . $_FILES[ 'arquivo' ][ 'type' ] . ' </strong ><br />';
  echo 'Temporáriamente foi salvo em: <strong>' . $_FILES[ 'arquivo' ][ 'tmp_name' ] . '</strong><br />';
  echo 'Seu tamanho é: <strong>' . $_FILES[ 'arquivo' ][ 'size' ] . '</strong> Bytes<br /><br />'; */

    $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
    $nome = $_FILES['arquivo']['name'];

    // Pega a extensão
    $extensao = pathinfo($nome, PATHINFO_EXTENSION);

    // Converte a extensão para minúsculo
    $extensao = strtolower($extensao);

    // Somente imagens, .jpg;.jpeg;.gif;.png
    // Aqui eu enfileiro as extensões permitidas e separo por ';'
    // Isso serve apenas para eu poder pesquisar dentro desta String
    if (strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
        // Cria um nome único para esta imagem
        // Evita que duplique as imagens no servidor.
        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
        $novoNome = uniqid(time()) . '.' . $extensao;

        // Concatena a pasta com o nome
        $destino = '../img/' . $novoNome;

        // tenta mover o arquivo para o destino
        if (@move_uploaded_file($arquivo_tmp, $destino)) {
            /* echo 'Arquivo salvo com sucesso em : <strong>' . $destino . '</strong><br />';
          echo ' < img src = "' . $destino . '" />'; */
        } else
            header('location: cadastrar.php?status=erro_cadastrar');
    } else
        header('location: cadastrar.php?status=erro_cadastrar');

};

  /* Pegando valores do formulario */
  if(isset($_POST['submit'])){
    $imagem = $novoNome;
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $paginas = $_POST['paginas'];
    $sinopse = $_POST['sinopse'];
    $cod_categoria = $_POST['cod_categoria'];
    $qtd_total = $_POST['qtd_total'];

    //Inserindo valores pego do formulario no banco de dados
    //Montando a query
    $query = $conn->prepare("INSERT INTO livro (imagem, titulo, autor, cod_categoria, paginas, sinopse, qtd_total) VALUES ( ?, ?, ?, ?, ?, ?, ?)");
    //Verificando dados inseridos e passando parametro de qual tipo eles ser. (evitar SQL INJECTION)
    $query->bind_param("sssiisi", $imagem, $titulo, $autor, $cod_categoria, $paginas, $sinopse, $qtd_total);
    //executa a query
    $query->execute();

    header('location:livros.php?status=success');
    /* echo "<pre>"; print_r($imagem); echo "</pre>"; exit; */
  };


  

?>

<section class="container-xl corpo">

<div class="caixa-formulario">
     <div class="titulo-index">
        <span>Cadastrar Livro</span>
    </div>

<!-- Formulario de cadastro de livros -->
  <form class="mt-4 formulario-cadastrar-livro" method="POST" enctype="multipart/form-data">

      <div class="mb-3">
        <label for="formFile" class="form-label">Imagem</label>
        <input class="form-control" type="file" name="arquivo" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Titulo</label>
        <input class="form-control" type="text" name="titulo" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Autor</label>
        <input class="form-control" type="text" name="autor" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoria</label>
        <select name="cod_categoria" class="form-select" >
        <option selected>Selecionar Categoria</option>
          <?php while($categoria = mysqli_fetch_assoc($resultQuery)){ ?>
          <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nome_categoria'] ?></option>
          <?php } ?>
        </select>
        </div>

      <div class="mb-3">
        <label class="form-label">Paginas</label>
        <input class="form-control" type="number" name="paginas" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Sinopse</label>
        <textarea class="form-control" name="sinopse"  placeholder="Digite a sinopse do livro..." style="height: 100px"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantidade</label>
        <input class="form-control" type="number  " name="qtd_total" required>
      </div>

      <div class="mb-3">
        <input class="btn btn-primary" type="submit" name="submit" value="Cadastrar Livro">
        <a class="btn btn-danger" href="livros.php">Cancelar</a>
      </div>
  </form>
</div>
</section>