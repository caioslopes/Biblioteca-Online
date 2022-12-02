<?php

    //Função responsavel por deletar o livro do banco de dados
    if(!empty($_GET['id'])){
        //Pega o id do livro, que foi passado por URL
        $id_livro = $_GET['id'];

        //Define o diretorio das imagens para poder excluir-las
        $pasta = '../img/';

        //Puxa os dados da tabela livros
        //Monta a query
        $querySelect = $conn->prepare("SELECT * FROM livro WHERE id_livro = $id_livro");
        //Executa da query
        $querySelect->execute();
        //Pega o resultado da execução da query
        $resultQuery = $querySelect->get_result();
        
        
        foreach($resultQuery as $livros){
            $titulo = $livros['titulo'];
            $imagem = $livros['imagem'];
            $autor = $livros['autor'];
            $qtd = $livros['qtd_total'];
        }

        if(isset($_POST['excluir'])){
            $id_livro2 = $_POST['livro'];


            $sqlConsulta = $conn->prepare("SELECT cod_livro FROM reserva WHERE cod_livro = $id_livro2
            UNION ALL 
            SELECT cod_livro FROM reserva_temp WHERE cod_livro = $id_livro2");
            $sqlConsulta->execute();
            $resultConsulta = $sqlConsulta->get_result();

            if($resultConsulta->num_rows >= 1){
                header('location: livros.php?status=error');
            }else{

                $sqlDelete = $conn->prepare("DELETE FROM livro WHERE id_livro = $id_livro2");
                $sqlDelete->execute();

                //Apaga a imagem da pasta de img
                unlink($pasta.$imagem);

                header('location: livros.php?status=success');
            };
        };  

    };
?>

<section class="container-xl mt-100px corpo">
    <div class="caixa-formulario">
        <div class="alert alert-danger" role="alert">
            Lembre-se excluir um livro é uma ação <b>Irreversível!</b>
        </div>

        <form method="POST">
            <div class="mt-3">
                <label>Imagem</label>
                <img style="width:10%;" src="../img/<?php echo $imagem ?>" alt="">
            </div>
            <div class="mt-3">
                <label>Id do Livro</label>
                <label class="form-control"><?php echo $id_livro ?></label>
            </div>
            <div class="mt-3">
                <label>Titulo</label>
                <label class="form-control"><?php echo $titulo ?></label>
                <input class="form-control" type="hidden" name="livro" value="<?php echo $id_livro ?>">
            </div>
            <div class="mt-3">
                <label>Autor</label>
                <label class="form-control"><?php echo $autor ?></label>
            </div>
            <div class="mt-3">
                <label>Quantidade de cópias</label>
                <label class="form-control"><?php echo $qtd ?></label>
            </div>
            <div class="mt-3">
                <input class="btn btn-sm btn-danger" type="submit" name="excluir" value="Excluir">
                <a class="btn btn-sm btn-primary" href="livros.php">Cancelar</a>
            </div>
        </form>
    </div>
</section>