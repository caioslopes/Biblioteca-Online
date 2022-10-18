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

</style>

<section class="container-xl mt-4">

 <div class="titulo-pagina">
    <h1>Livros Disponiveis</h1>
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
             <img src='img/<?php echo $livros['imagem'] ?>' class="capa-livros"  alt="Imagem da capa do livro">
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