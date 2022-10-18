<?php 

    if(isset($_GET['id_livro'])){
        $id_livro_past = $_GET['id_livro'];
    };

            
    $umDia = new DateInterval('P1D');

    $hojeSom = new DateTime();

    $prazoUmDia = $hojeSom->add($umDia);

    $hoje = date('d/m');

    $sqlSelectAluno = $conn->prepare("SELECT nome_aluno FROM aluno WHERE id_aluno = $id_aluno");
    $sqlSelectAluno->execute();
    $resultSelectAluno = $sqlSelectAluno->get_result();

    while($dados_aluno = mysqli_fetch_assoc($resultSelectAluno)){
        $nome_aluno = $dados_aluno['nome_aluno'];
    };


    $sqlSelectLivro = $conn->prepare("SELECT titulo FROM livro WHERE id_livro = $id_livro_past");
    $sqlSelectLivro->execute();
    $resultSelectLivro = $sqlSelectLivro->get_result();

    while($dados_livro = mysqli_fetch_assoc($resultSelectLivro)){
        $titulo_livro = $dados_livro['titulo'];
    };

    if(isset($_POST['reservar'])){
        $res_livro = $_POST['cod_livro'];
        $res_aluno = $_POST['cod_aluno'];
        $res_data_hoje = $_POST['data_hoje'];
        $res_data_prazo = $_POST['data_prazo'];

        $sqlInsert = $conn->prepare("INSERT INTO reserva_temp (cod_livro, cod_aluno, data_hoje, data_prazo) VALUES($res_livro, $res_aluno, $res_data_hoje, $res_data_prazo )");
        $sqlInsert->execute();
    }


?>

<section class="container-xl corpo">

    <div class="alert alert-warning" role="alert">
        Lembre-se que você apenas pode fazer a reserva de <b>um</b> livro por vez!
    </div>

    <form>
        <div class="mt-3">
            <label>Livro</label>
            <input class="form-control" type="text" value="<?php echo $titulo_livro ?>" disabled>
            <input class="form-control" type="hidden" name="cod_livro" value="<?php echo $id_livro ?>">
        </div>
        <div class="mt-3">
            <label>Aluno</label>
            <input class="form-control" type="text" value="<?php echo $nome_aluno ?>" disabled> 
            <input class="form-control" type="hidden" name="cod_aluno" value="<?php echo $id_aluno ?>">
        </div>
        <div class="mt-3">
            <label>Data da Reserva</label>
            <input  class="form-control" type="text" name="data_hoje" value="<?php echo $hoje ?>" disabled>
        </div>
        <div class="mt-3">
            <label>Prazo para confirmar</label>
            <input class="form-control" type="text" name="data_prazo" value="<?php echo $prazoUmDia->format('d/m'); ?>" disabled>
        </div>
        <div class="mt-3">
            <input class="btn btn-primary" type="submit" name="reservar" value="Confirmar">
            <a class="btn btn-danger" href="livros.php">Cancelar</a>
        </div>
    </form>
</section>