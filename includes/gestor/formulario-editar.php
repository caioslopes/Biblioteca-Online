<!-- Abrindo codigo php -->
<?php 
     //Função para selecionar dados categoria
     $querySelect2 = $conn->prepare("SELECT * FROM categoria");
     $querySelect2->execute();
     $resultQuery2 = $querySelect2->get_result();

     
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
            header('location: livros.php?status=erro_editar');
    } else
        header('location: livros.php?status=erro_editar');
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
            $imagem = $user_data['imagem'];
            $titulo = $user_data['titulo'];
            $autor = $user_data['autor'];
            $cod_categoria = $user_data['cod_categoria'];
            $qtd_total = $user_data['qtd_total'];
        };
     };

    if(!empty($_POST['editar'])){
        $imagem_editar = $novoNome;
        $imagem_banco = $_POST['imagem_banco'];
        $titulo_editar = $_POST['titulo'];
        $autor_editar = $_POST['autor'];
        $cod_categoria_editar = $_POST['cod_categoria'];
        $quantidade_editar = $_POST['qtd_total'];

        //Verificando se alguma imagem foi enviada ou não
        if(!empty($novoNome)){
        //Monta a query
        $queryUpdate = $conn->prepare("UPDATE livro SET imagem = ?, titulo = ?, autor = ?, cod_categoria = ?, qtd_total = ? WHERE id_livro = ?");
        //Separa os valores inseridos da query
        $queryUpdate->bind_param("sssiii", $imagem_editar, $titulo_editar, $autor_editar, $cod_categoria_editar, $quantidade_editar, $id_livro);
        //Executa da query
        $queryUpdate->execute();
        }else{
        //Monta a query
        $queryUpdate = $conn->prepare("UPDATE livro SET imagem = ?, titulo = ?, autor = ?, cod_categoria = ?, qtd_total = ? WHERE id_livro = ?");
        //Separa os valores inseridos da query
        $queryUpdate->bind_param("sssiii", $imagem_banco, $titulo_editar, $autor_editar, $cod_categoria_editar, $quantidade_editar, $id_livro);
        //Executa da query
        $queryUpdate->execute();
        }

        header('location: livros.php?status=success');
        exit;
    };
}

?>

<section class="container-xl corpo">

<div class="caixa-formulario">
     <div class="titulo-index">
        <span>Editar Livro</span>
    </div>

<!-- Formulario para editar os livros -->
  <form class="mt-4" method="POST" enctype="multipart/form-data">

      <div class="mb-3">
        <label class="form-label">Imagem</label>
        <img style="width: 100px;" src="../img/<?php echo $imagem ?>" alt="">
        <input class="form-control mt-3" type="file" name="arquivo">
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
        <select name="cod_categoria" class="form-select">
          <?php $consultaCategoria = $conn->prepare("SELECT nome_categoria FROM categoria WHERE id_categoria = $cod_categoria");
                $consultaCategoria->execute();
                $resultConsultaCategoria = $consultaCategoria->get_result();

                foreach($resultConsultaCategoria as $dados_categoria){
                    $nome_categoria = $dados_categoria['nome_categoria'];
                };
           ?>
          <option value="<?php echo $cod_categoria ?>" selected><?php echo $nome_categoria ?></option>
          <?php while($categoria = mysqli_fetch_assoc($resultQuery2)){ ?>
          <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nome_categoria'] ?></option>
          <?php } ?>
        </select>
        </div>

      <div class="mb-3">
        <label class="form-label">Quantidade</label>
        <input class="form-control" type="text" name="qtd_total" value="<?php echo $qtd_total ?>" required>
      </div>

      <div class="mb-3">
        <input class="btn btn-primary" type="submit" name="editar" value="Editar Livro">
        <a class="btn btn-danger" href="livros.php">Cancelar</a>
      </div>
  </form>
  </div>

</section>