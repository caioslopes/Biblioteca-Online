<?php 
    $id_livro = null;

    if(!empty($_GET['id_livro'])){
        $id_livro = $_GET['id_livro'];

        date_default_timezone_set('America/Sao_Paulo');

  
        // Store datetime in variable today
        $today = new DateTimeImmutable();   
        $dia = new DateInterval('P1D'); 
        $soma = $today->add($dia);
        $amanha = $soma->format('Y-m-d H-i');
        $hoje = $today->format('Y-m-d H-i');
        $diaf = $soma->format('d/m/Y');
        $diaH = $today->format('d/m/Y');

        //Função que puxa os dados da tabela livro para exibir ao usuario
        $sqlSelect = $conn->prepare("SELECT * FROM livro, aluno WHERE id_aluno = $id_aluno AND id_livro = $id_livro");
        $sqlSelect->execute();
        $resultSelect = $sqlSelect->get_result();

        foreach ($resultSelect as $dados){
            $titulo = $dados['titulo'];
            $nome_aluno = $dados['nome_aluno'];
            $qtd_total = $dados['qtd_total'];
            $qtd_reserva = $dados['qtd_reserva'];
            $qtd_temp = $dados['qtd_temp'];

            /* echo "<pre>"; print_r($dados); echo "</pre>"; exit; */
        };

        if(isset($_POST['reservar'])){
            $value_livro = $_POST['livro'];
            $value_aluno = $_POST['aluno'];
            $value_hoje = $_POST['hoje'];
            $value_amanha = $_POST['amanha'];

            if($qtd_reserva + $qtd_temp >= $qtd_total ){
                header('location: livros.php?status=error');
            exit;
            }else{

            $sqlInsert = $conn->prepare("INSERT INTO reserva_temp (cod_livro, cod_aluno, data_hoje, data_amanha) VALUES(?, ?, ?, ?)");
            $sqlInsert->bind_param("iiss", $value_livro, $value_aluno, $value_hoje, $value_amanha);
            $sqlInsert->execute();

            //Soma para podermos verificar quantidades
            $sqlInsertQtd = $conn->prepare("UPDATE livro SET qtd_temp = qtd_temp +1 WHERE id_livro = $id_livro");
            $sqlInsertQtd->execute();
            header('location: perfil.php?status=success');
            exit;
            }
                
            /* echo "<pre>"; print_r($value_livro); echo "</pre>"; exit; */
        }
        /* echo "<pre>"; print_r($dados); echo "</pre>"; exit; */
    }else{
        echo 'Error';
    }

    
?>

 <section class="container-xl corpo">
    <div class="caixa-confirmar">
        <div class="alert alert-warning" role="alert">
            Lembre-se que você apenas pode fazer a reserva de <b>um</b> livro por vez!
        </div>

        <form method="POST">
            <div class="mt-3">
                <label>Livro</label>
                <label class="form-control"><?php echo $titulo ?></label>
                <input class="form-control" type="hidden" name="livro" value="<?php echo $id_livro ?>">
            </div>
            <div class="mt-3">
                <label>Aluno</label>
                <label class="form-control"><?php echo $nome_aluno ?></label>
                <input class="form-control" type="hidden" name="aluno" value="<?php echo $id_aluno ?>">
            </div>
            <div class="mt-3">
                <label>Data do pedido</label>
                <label class="form-control"><?php echo $diaH ?></label>
                <input class="form-control" type="hidden" name="hoje" value="<?php echo $hoje ?>">
            </div>
            <div class="mt-3">
                <label>Data da confirmação</label>
                <label class="form-control"><?php echo $diaf ?></label>
                <input class="form-control" type="hidden" name="amanha" value="<?php echo $amanha ?>">
            </div>
            <div class="mt-3">
                <input class="btn btn-sm btn-primary" type="submit" name="reservar" value="Fazer Pedido">
                <a class="btn btn-sm btn-danger" href="livros.php">Cancelar</a>
            </div>
        </form>
    </div>
</section>