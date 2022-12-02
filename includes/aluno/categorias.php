<!-- Conteudo que mostrara os livros cadastrados no sistema -->
<?php  
    if(isset($_GET['id_categoria'])){
        $id_categoria = $_GET['id_categoria'];

        //Seleciona os livros referente a categoria selecionada
        $sql = $conn->prepare("SELECT * FROM livro WHERE cod_categoria = $id_categoria");
        $sql->execute();
        $result = $sql->get_result();

        //Seleciona categoria
        $SelectCategoria = $conn->prepare("SELECT * FROM categoria");
        $SelectCategoria->execute();
        $resultCategoria = $SelectCategoria->get_result();

        //Seleciona categoria
        $SelectCategoria2 = $conn->prepare("SELECT * FROM categoria WHERE id_categoria = $id_categoria");
        $SelectCategoria2->execute();
        $resultCategoria2 = $SelectCategoria2->get_result();
   
    }
  ?>

<section class="container-xl mt-100px corpo">
    <div class="d-flex justify-content-between titulo-pagina">
        <div class="titulo-index">
            <?php while($nomecat = mysqli_fetch_assoc($resultCategoria2)){
                $nomecatuot =  $nomecat['nome_categoria'];  ?>
                <span><?php echo $nomecat['nome_categoria'] ?></span>
           <?php } ?>
        </div>

        <div class="caixa-busca">
            <div class="caixa-categoria">
                <div class="btn-group">
                <button class="btn btn-secondary dropdown-toggle btn-padrao" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    <?php if(isset($_GET['id_categoria'])){ echo $nomecatuot; }else{ echo 'Categoria'; } ?>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="livros.php">Todos os Livros</a></li>
                    <?php
                        while($dados = mysqli_fetch_assoc($resultCategoria)){ ?>
                            <li><a class="dropdown-item" href="categorias.php?id_categoria=<?php echo $dados['id_categoria']; ?>"><?php echo $dados['nome_categoria']; ?></a></li>
                      <?php  } ?>
                </ul>
                </div>
            </div>

            <form class="d-flex" role="search" method="POST" action="pesquisa-livros.php">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar um livro...">
                <button class="btn btn-busca" type="submit">Buscar Livro</button>
            </form>
        </div>
    </div>

        <div class="fundo__vitrine--livros mt-4">
        <section class="container-xl">
            <div class="vitrine">
            <?php while ($livros = mysqli_fetch_assoc($result)) {?>
                <div class="livros">
                    <a class="livro-link" href="pagina-interna-livros.php?id_livro=<?php echo $livros['id_livro'] ?>">
                        <img src='../img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
                        <div class="caixa-btn">
                            <div class="caixa-titulo">
                                <span><?php echo $livros['titulo'] ?></span>
                            </div>
                    </a>
                </div>
            </div>
            <?php } ?>
            </div>
        </section>
        </div>
    
</section>