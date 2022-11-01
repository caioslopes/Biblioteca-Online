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
.caixa-busca{
    display: flex;
    justify-content: center;
    gap: 70px;
}
.btn-categoria{
    padding: 0px 30px;
    border-radius: 20px;
    height: 39px;
}
.btn-reserva{
    width: 100%;
    border-radius: 20px;
}
.caixa-categoria span{
    margin-right: 10px;
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
        gap: 30px;
    }
    .caixa-busca{
        width: 90%;
        margin-bottom: 20px;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    .caixa-categoria{
        order: 1;
    }
}
</style>

<section class="container-xl mt-4 corpo">

    <div class="d-flex justify-content-between titulo-pagina">
        <div>
            <h1>Livros Disponiveis</h1>
        </div>
        <div class="caixa-busca">
        <div class="caixa-categoria">
                <span>Buscar por</span>
                <button class="btn-categoria">
                    Categoria
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                    </svg>
                </button>
            </div>

            <form class="d-flex" role="search" method="GET">
                <input class="form-control me-2 rounded-pill" type="search" name="busca" placeholder="Buscar um livro" value="<?php if (isset($_GET['busca'])){ echo $_GET['busca']; } ?>">
                <button class="btn btn-outline-primary rounded-circle" type="submit">
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

    //Consulta a tabela reserva_temp e reserva para verificar se o aluno pode ou não reservar novo livro
    $reserva_temp = $conn->prepare("SELECT cod_aluno FROM reserva_temp WHERE cod_aluno = $id_aluno");
    $reserva_temp->execute();
    $resultReserva_temp = $reserva_temp->get_result();

    $reserva = $conn->prepare("SELECT cod_aluno FROM reserva WHERE cod_aluno = $id_aluno");
    $reserva->execute();
    $resultreserva = $reserva->get_result();



  ?>
  <?php if(empty($_GET['busca'])){?>
      <div class="fundo__vitrine--livros mt-4">
      <section class="container-xl">
        <div class="vitrine">
          <?php while ($livros = mysqli_fetch_assoc($result)) {?>
          <div class="livros">
              <img src='../img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
              <div class="vitrine__livros--texto">
                <?php if($resultReserva_temp->num_rows >= 1 || $resultreserva->num_rows >=1){ ?>
                    <a tabindex="0" class="btn btn-sm btn-secondary btn-reserva" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Você já possui um livro reservado">Reservar</a>   
                <?php  }else if($livros['qtd_reserva'] + $livros['qtd_temp'] >= $livros['qtd_total'] ){ ?>
                    <a tabindex="0" class="btn btn-sm btn-secondary btn-reserva" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Aguarde a devolução do livro">Indisponivel</a>   
                <?php } else {?>
                    <a class="btn btn-sm btn-primary btn-reserva" href="confirmacao-reserva.php?id_livro=<?php echo $livros['id_livro'] ?>">Reservar</a>
                <?php } ?>
              </div>
          </div>
          <?php }; ?>
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
         <?php
        } else { 
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
                            <div class="vitrine__livros--texto">
                                <?php if($resultReserva_temp->num_rows >= 1 || $resultreserva->num_rows >=1){ ?>
                                    <a tabindex="0" class="btn btn-sm btn-secondary" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Você já possui um livro reservado">Reservar</a>   
                                <?php  }else{ ?>
                                    <a class="btn btn-sm btn-primary" href="confirmacao-reserva.php?id_livro=<?php echo $livro_busca['id_livro'] ?>">Reservar</a>
                                <?php }?>
                            </div>
                        </div>
                        <?php } ?>
                        </div>
                    </section>
                </div>
       
   <?php }} ?>
</section>