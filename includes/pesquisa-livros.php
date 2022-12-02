<!-- Conteudo que mostrara os livros pesquisados -->
<section class="container-xl mt-100px min-hei">
    <div class="d-flex justify-content-between titulo-pagina">
        <div class="caixa-busca">
            <div class="titulo-index">
                <span>Resultado da pesquisa</span>
            </div>
            <div class="caixa-categoria">
                <div class="btn-group">
                <button class="btn dropdown-toggle btn-padrao" type="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                    Categorias
                </button>
                <ul class="dropdown-menu">
                    <?php 
                        $SelectCategoria = $conn->prepare("SELECT * FROM categoria");
                        $SelectCategoria->execute();
                        $resultCategoria = $SelectCategoria->get_result(); ?>

                    <li><a class="dropdown-item" href="index.php">Todos os Livros</a></li>
                    
                     <?php   while($dados = mysqli_fetch_assoc($resultCategoria)){ ?>
                            <li><a class="dropdown-item" href="categorias.php?id_categoria=<?php echo $dados['id_categoria']; ?>"><?php echo $dados['nome_categoria']; ?></a></li>
                      <?php  } ?>
                </ul>
                </div>
            </div>

            <form class="d-flex" role="search" method="POST" action="pesquisa-livros.php">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar um livro..." value="<?php if (isset($_POST['busca'])){ echo $_POST['busca']; } ?>">
                <button class="btn btn-busca" type="submit">Buscar Livro</button>
            </form>
        </div>
    </div>

    <!-- Resultado da pesquisa do usuario -->
    <?php
        if(!empty($_POST['busca'])) { 
            //Pega o valor digitado pelo usuario na barra de pesquisa
            $busca = $_POST['busca'];    

            //Selecionando informações do banco segundo o que o usuario digitou
            $SelectBusca = $conn->prepare("SELECT * FROM livro WHERE titulo LIKE '%$busca%' OR autor LIKE '%$busca%'");
            $SelectBusca->execute();
            $resultBusca = $SelectBusca->get_result();
        
        if($resultBusca->num_rows == 0){ ?>
                <div class="nenhum-resultado alert alert-warning">
                    <span>Nenhum resultado encontrado</span>
                    <a class="btn btn-padrao" href="index.php">Livros</a>
                </div>
       <?php  }else { ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="vitrine">
                        <?php while ($livro_busca = mysqli_fetch_assoc($resultBusca)) {?>
                        <div class="livros">
                            <a class="livro-link" href="pagina-interna-livros.php?id_livro=<?php echo $livro_busca['id_livro'] ?>">
                                <img src='img/<?php echo $livro_busca['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
                                <div>
                                    <span><?php echo $livro_busca['titulo'] ?></span>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                        </div>
                    </section>
                </div>
       
   <?php }}else{ ?>

                <div class="nenhum-resultado alert alert-primary">
                    <span>Pesquise alguma coisa :)</span>   
                    <a class="btn btn-padrao" href="index.php">Livros</a>
                </div>
        
 <?php  } ?>
</section>