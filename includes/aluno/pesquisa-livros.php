<!-- Conteudo que mostrara os livros cadastrados no sistema -->
<style>
  .vitrine {
   display: grid;
    grid-template-columns: repeat(6, 1fr);
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

.livros:hover {
    transform: scale(1.05);
    cursor: pointer;
}

/* Paginação */
.link-pag {
    color: #23232e;
    border: 1px solid #23232e;
    padding: 10px;
    margin-left: 5px;
    border-radius: 40px;
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
.titulo-pagina{
    text-align: center;
    /* flex-direction: column; */
    gap: 30px;
}
.caixa-busca{
    display: flex;
    justify-content: center;
    gap: 70px;
}
.btn-categoria{
    height: 100%;
    padding: 0px 30px;
    border-radius: 20px;
}
.caixa-categoria span{
    margin-right: 10px;
}
.nenhum-resultado{
    margin-top: 30px;
    text-align: center;
}
.caixa-titulo{
    min-height: 50px;
}
.btn-reserva{
    width: 100%;
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

<section class="container-xl mt-4">
    <div class="d-flex justify-content-between titulo-pagina">
        <div class="titulo-index">
            <h1>Resultado da pesquisa</h1>
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
                        $resultCategoria = $SelectCategoria->get_result();

                        while($dados = mysqli_fetch_assoc($resultCategoria)){ ?>
                            <li><a class="dropdown-item" href="categorias.php?id_categoria=<?php echo $dados['id_categoria']; ?>"><?php echo $dados['nome_categoria']; ?></a></li>
                      <?php  } ?>
                </ul>
                </div>
            </div>

            <form class="d-flex" role="search" method="POST">
                <input class="form-control me-2 rounded-pill" type="search" name="busca" placeholder="Buscar um livro..." value="<?php if (isset($_POST['busca'])){ echo $_POST['busca']; } ?>">
                <button class="btn btn-outline-primary rounded-circle" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
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
            
            //Consulta a tabela reserva_temp e reserva para verificar se o aluno pode ou não reservar novo livro
            $reserva_temp = $conn->prepare("SELECT cod_aluno FROM reserva_temp WHERE cod_aluno = $id_aluno");
            $reserva_temp->execute();
            $resultReserva_temp = $reserva_temp->get_result();

            $reserva = $conn->prepare("SELECT cod_aluno FROM reserva WHERE cod_aluno = $id_aluno");
            $reserva->execute();
            $resultreserva = $reserva->get_result();
        
        if($resultBusca->num_rows == 0){ ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="nenhum-resultado">
                            <h4>Nenhum resultado encontrado... <a class="btn btn-primary rounded-pill" href="livros.php">Voltar para Livros</a></h4>
                        </div>
                    </section>
                </div>

       <?php  }else { ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="vitrine">
                        <?php while ($livro_busca = mysqli_fetch_assoc($resultBusca)) {?>
                        <div class="livros">
                            <img src='../img/<?php echo $livro_busca['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
                            <div class="caixa-titulo">
                                <span><?php echo $livro_busca['titulo'] ?></span>
                            </div>
                            <?php if($resultReserva_temp->num_rows >= 1 || $resultreserva->num_rows >=1){ ?>
                                <a tabindex="0" class="btn btn-sm rounded-pill btn-secondary btn-reserva" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Você já possui um livro reservado">Reservar</a>   
                            <?php  }else if($livro_busca['qtd_reserva'] + $livro_busca['qtd_temp'] >= $livro_busca['qtd_total'] ){ ?>
                                <a tabindex="0" class="btn btn-sm rounded-pill  btn-secondary btn-reserva" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Aguarde a devolução do livro">Indisponivel</a>   
                            <?php } else {?>
                                <a class="btn rounded-pill btn-sm btn-primary btn-reserva" href="confirmacao-reserva.php?id_livro=<?php echo $livro_busca['id_livro'] ?>">Reservar</a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        </div>
                    </section>
                </div>
       
   <?php }}else{ ?>
                <div class="fundo__vitrine--livros mt-4">
                    <section class="container-xl">
                        <div class="nenhum-resultado">
                            <a class="btn btn-primary rounded-pill" href="livros.php">Voltar para Livros</a>
                        </div>
                    </section>
                </div>
 <?php  } ?>
</section>