<?php 
    $id_livro = null;

    if(!empty($_GET['id_temp'])){
        $id_temp = $_GET['id_temp'];

        
        $sql = $conn->prepare("SELECT * FROM reserva_temp
        INNER JOIN livro
        ON id_livro = reserva_temp.cod_livro
        INNER JOIN aluno
        ON id_aluno = reserva_temp.cod_aluno
        WHERE reserva_temp.id_temp = $id_temp");
        $sql->execute();
        $result = $sql->get_result();

        foreach ($result as $dados){
            $id_livro = $dados['id_livro'];
            $id_aluno = $dados['id_aluno'];
            $titulo = $dados['titulo'];
            $nome_aluno = $dados['nome_aluno'];
            $data_hoje = $dados['data_hoje'];
            $data_amanha = $dados['data_amanha'];

            /* echo "<pre>"; print_r($dados); echo "</pre>"; exit; */
        };
    
            // echo "<pre>"; print_r($_POST['confirmar']); echo "</pre>"; exit; 

                //Transferirindo os dados para tabela "reserva" (tornado efetivo)
                if(!empty($_POST['confirmar'])){
                    $livro = $_POST['livro'];
                    $aluno = $_POST['aluno'];
                    $data_hoje = $_POST['hoje'];
                    $data_amanha = $_POST['amanha'];
                    
                    //Função para tranferencia de dados
                    $sqlInsert = $conn->prepare("INSERT INTO reserva(cod_aluno, cod_livro, data_da_reserva,	data_da_entrega) VALUES(?, ?, ?, ?)");
                    $sqlInsert->bind_param("iiss", $aluno, $livro, $data_hoje, $data_amanha);
                    $sqlInsert->execute();

                    //Consulta tabela livros para checar o campo qtd_temp
                    $sqlSelect = $conn->prepare("");
                    $sqlInsert->execute();

                    if(){
                        //Função para excluir dados das tabela temporaria
                        $sqlDelete = $conn->prepare("DELETE FROM reserva_temp WHERE cod_livro = $livro");
                        $sqlDelete->execute();                    
                        
                        //Função atualizar tabela livro
                        $sqlUpdate = $conn->prepare("UPDATE livro SET qtd_temp = qtd_temp -1 WHERE id_livro = $livro");
                        $sqlUpdate->execute();
    
                        header('location: registros-reservas-temp.php?status=success');
                    };

                };

    }

    
?>

 <section class="container-xl corpo">
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
            <label class="form-control"><?php echo $data_hoje ?></label>
            <input class="form-control" type="hidden" name="hoje" value="<?php echo $data_hoje ?>">
        </div>
        <div class="mt-3">
            <label>Data da confirmação</label>
            <label class="form-control"><?php echo $data_amanha ?></label>
            <input class="form-control" type="hidden" name="amanha" value="<?php echo $data_amanha ?>">
        </div>
        <div class="mt-3">
            <input class="btn btn-sm btn-primary" type="submit" name="confirmar" value="Confirmar">
            <a class="btn btn-sm btn-danger" href="registros-reservas-temp.php">Cancelar</a>
        </div>
    </form>
</section>