<?php

    if (!empty($_GET['id_livro'])) {

        $id_livro = $_GET['id_livro'];

        $sqlSelect = $conn->prepare("SELECT * FROM livro WHERE id_livro = $id_livro");
        $sqlSelect->execute();
        $resultSelect = $sqlSelect->get_result();

        foreach ($resultSelect as $dados) {
            $imagem = $dados['imagem'];
            $titulo = $dados['titulo'];
            $autor = $dados['autor'];
            $categoria = $dados['cod_categoria'];
            $paginas = $dados['paginas'];
            $sinopse = $dados['sinopse'];
            $qtd_total = $dados['qtd_total'];
            $qtd_reserva = $dados['qtd_reserva'];
            $qtd_temp = $dados['qtd_temp'];
        };

        $sqlCategoria = $conn->prepare("SELECT nome_categoria FROM categoria WHERE id_categoria = $categoria");
        $sqlCategoria->execute();
        $resultCategoria = $sqlCategoria->get_result();

        foreach ($resultCategoria as $nome_cat) {
            $nome_categoria = $nome_cat['nome_categoria'];
        }
    };

    //Consulta a tabela reserva_temp e reserva para verificar se o aluno pode ou não reservar novo livro
    $reserva_temp = $conn->prepare("SELECT cod_aluno FROM reserva_temp WHERE cod_aluno = $id_aluno");
    $reserva_temp->execute();
    $resultReserva_temp = $reserva_temp->get_result();

    //Consulta a tabela reserva e reserva para verificar se o aluno pode ou não reservar novo livro
    $reserva = $conn->prepare("SELECT cod_aluno FROM reserva WHERE cod_aluno = $id_aluno");
    $reserva->execute();
    $resultreserva = $reserva->get_result();

?>
<section class="container-xl corpo">
    <div class="caixa-interna">
        <div class="d-flex caixa-livro-interna">
            <div class="btn-voltar">
                <a href="livros.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                    </svg>
                </a>
            </div>
            <div class="caixa-imagem-livro-interna">
                <img class="imagem-livro-interna" src="../img/<?php echo $imagem ?>" alt="">
            </div>
            <div class="caixa-texto-interna">
                <h1><?php echo $titulo ?></h1>
                <span><?php echo $autor ?></span>
                <span><?php echo $nome_categoria ?></span>
                <span><?php echo $paginas ?></span>
                <div class="caixa-copias">
                    <div class="copias-disponiveis">
                        <span>Cópias disponíveis</span>
                        <span>
                            <?php if($qtd_reserva + $qtd_temp <= $qtd_total){
                                
                                    $alugados = $qtd_reserva + $qtd_temp;

                                    $subtração = $qtd_total - $alugados;

                                    echo $subtração;
                            }else {
                                
                                    echo '0';
                            } 
                            ?> 
                        </span>
                    </div>
                </div>
                <div>
                 <?php if($resultReserva_temp->num_rows >= 1 || $resultreserva->num_rows >=1){ ?>
                    <a tabindex="0" class="btn btn-padrao-invertido btn-reserva" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Você já possui um livro reservado">Reservar</a>   
                <?php  }else if($qtd_reserva + $qtd_temp >= $qtd_total ){ ?>
                    <a tabindex="0" class="btn btn-padrao-invertido btn-reserva" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-title="Aviso" data-bs-content="Aguarde a devolução do livro">Indisponivel</a>   
                <?php } else {?>
                    <a class="btn btn-padrao-invertido btn-reserva" href="confirmacao-reserva.php?id_livro=<?php echo $id_livro ?>">Reservar</a>
                <?php } ?> 
                </div>
            </div>
        </div>
        <div class="caixa-sinopse">
            <span>Sinopse</span>
            <div class="caixa-sinopse-texto" >
                <?php echo $sinopse ?>
            </div>
        </div>
    </div>

</section>