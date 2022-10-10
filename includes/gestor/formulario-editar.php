<!-- Abrindo codigo php -->
<?php 

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
            echo 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
    } else
        echo 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
};

if(!empty($_GET['id'])){

    //Pega o id que foi passado por URL
    $id_livro = $_GET['id'];

      //Monta a query
      $querySelect = $conn->prepare("SELECT * FROM livro WHERE id_livro = ?");
      //Separa o valor do id da query
      $querySelect->bind_param("i", $id_livro);
      //Executa da query
      $querySelect->execute();
      //Pega o resultado da query
      $resultQuery = $querySelect->get_result();

      // Verifica se o resultado da função acima é maior que 0 (se tem algum resultado)
      if ($resultQuery->num_rows > 0) {
        //Se tiver algum resultado retorna este resultado num array 
        while ($user_data = mysqli_fetch_assoc($resultQuery)) {
            //Pega os valores da $resutlQuery e joga em variaveis
            $cod_livro = $user_data['cod_livro'];
            $imagem = $user_data['imagem'];
            $titulo = $user_data['titulo'];
            $autor = $user_data['autor'];
            $cod_categoria = $user_data['cod_categoria'];
            $quantidade = $user_data['quantidade'];
        };
     };

    if(!empty($_POST['editar'])){
        $cod_livro_editar = $_POST['cod_livro'];
        $imagem_editar = $novoNome;
        $imagem_banco = $_POST['imagem_banco'];
        $titulo_editar = $_POST['titulo'];
        $autor_editar = $_POST['autor'];
        $cod_categoria_editar = $_POST['cod_categoria'];
        $quantidade_editar = $_POST['quantidade'];

        //Verificando se alguma imagem foi enviada ou não
        if(!empty($novoNome)){
        //Monta a query
        $queryUpdate = $conn->prepare("UPDATE livro SET cod_livro = ?, imagem = ?, titulo = ?, autor = ?, cod_categoria = ?, quantidade = ? WHERE id_livro = ?");
        //Separa os valores inseridos da query
        $queryUpdate->bind_param("ssssiii", $cod_livro_editar, $imagem_editar, $titulo_editar, $autor_editar, $cod_categoria_editar, $quantidade_editar, $id_livro);
        //Executa da query
        $queryUpdate->execute();
        }else{
        //Monta a query
        $queryUpdate = $conn->prepare("UPDATE livro SET cod_livro = ?, imagem = ?, titulo = ?, autor = ?, cod_categoria = ?, quantidade = ? WHERE id_livro = ?");
        //Separa os valores inseridos da query
        $queryUpdate->bind_param("ssssiii", $cod_livro_editar, $imagem_banco, $titulo_editar, $autor_editar, $cod_categoria_editar, $quantidade_editar, $id_livro);
        //Executa da query
        $queryUpdate->execute();
        }

        header('location: home.php?=status=success');
        exit;
    };
}

?>

<section class="container-xl">
<!-- Formulario para editar os livros -->
  <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Codigo do Livro</label>
        <input class="form-control" type="text" name="cod_livro" value="<?php echo $cod_livro ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Imagem</label>
        <img style="width: 100px;" src="../img/<?php echo $imagem ?>" alt="">
        <input class="form-control" type="file" name="arquivo">
        <input type="hidden" name="imagem_banco" value="<?php echo $imagem ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Titulo</label>
        <input class="form-control" type="text" name="titulo" value="<?php echo $titulo ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Autor</label>
        <input class="form-control" type="text" name="autor" value="<?php echo $autor ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Categoria</label>
        <input class="form-control" type="text" name="cod_categoria" value="<?php echo $cod_categoria ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Quantidade</label>
        <input class="form-control" type="text" name="quantidade" value="<?php echo $quantidade ?>" required>
      </div>

      <div class="mb-3">
        <input class="btn btn-primary" type="submit" name="editar" value="Cadastrar Livro">
      </div>
  </form>

</section>