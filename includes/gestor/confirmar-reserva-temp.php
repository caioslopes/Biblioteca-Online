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
            $qtd_temp = $dados['qtd_temp'];
            $qtd_reserva = $dados['qtd_reserva'];
            $qtd_total = $dados['qtd_total'];



            /*  echo "<pre>"; print_r($dados); echo "</pre>"; exit; */
        };
    
            // echo "<pre>"; print_r($_POST['confirmar']); echo "</pre>"; exit; 

                //Transferirindo os dados para tabela "reserva" (tornado efetivo)
                if(!empty($_POST['confirmar'])){
                    $livro = $_POST['livro'];
                    $aluno = $_POST['aluno'];
                    $data_hoje = $_POST['hoje'];
                    $data_amanha = $_POST['amanha'];

                    //Pega a data atual da confirmação e soma 10 dias.
                    $today = new DateTimeImmutable();   
                    $dia = new DateInterval('P10D'); 
                    $soma = $today->add($dia);
                    $DezDia = $soma->format('Y-m-d');
                                          
                    //Pega o dia da semana
                    $DiaSemana = date('l',strtotime($DezDia));
                    echo $DiaSemana;
                    

                    if($qtd_temp <= 0){
                        header('registros-reservas-temp.php?status=error');
                    }else if($qtd_temp + $qtd_reserva >= $qtd_total){
                        header('registros-reservas-temp.php?status=error');
                    }else if($DiaSemana == 'Saturday'){

                        $today = new DateTimeImmutable();   
                        $dia = new DateInterval('P12D'); 
                        $soma = $today->add($dia);
                        $DezDia = $soma->format('Y-m-d');

                        //Função para tranferencia de dados -> tabela reserva
                        $sqlInsert = $conn->prepare("INSERT INTO reserva(cod_aluno, cod_livro, data_da_reserva,	data_da_entrega) VALUES(?, ?, ?, ?)");
                        $sqlInsert->bind_param("iiss", $aluno, $livro, $data_hoje, $DezDia);
                        $sqlInsert->execute();
  
                        //Função para tranferencia de dados -> tabela registro
                        $sqlInsert2 = $conn->prepare("INSERT INTO registro(cod_aluno, cod_livro, data_da_reserva, data_da_entrega) VALUES(?, ?, ?, ?)");
                        $sqlInsert2->bind_param("iiss", $aluno, $livro, $data_hoje, $DezDia);
                        $sqlInsert2->execute();
  
                        //Função para excluir dados das tabela temporaria
                        $sqlDelete = $conn->prepare("DELETE FROM reserva_temp WHERE id_temp = $id_temp");
                        $sqlDelete->execute();                    
                          
                        //Função atualizar tabela livro qtd_temp
                        $sqlUpdate = $conn->prepare("UPDATE livro SET qtd_temp = qtd_temp -1 WHERE id_livro = $livro");
                        $sqlUpdate->execute();
  
                        //Função atualizar tabela livro qtd_reserva
                        $sqlUpdate2 = $conn->prepare("UPDATE livro SET qtd_reserva = qtd_reserva +1 WHERE id_livro = $livro");
                        $sqlUpdate2->execute();
  
                        header('location: registros-reservas-temp.php?status=success');

                    }else if($DiaSemana == 'Monday'){
                        $today = new DateTimeImmutable();   
                        $dia = new DateInterval('P11D'); 
                        $soma = $today->add($dia);
                        $DezDia = $soma->format('Y-m-d');

                        //Função para tranferencia de dados -> tabela reserva
                        $sqlInsert = $conn->prepare("INSERT INTO reserva(cod_aluno, cod_livro, data_da_reserva,	data_da_entrega) VALUES(?, ?, ?, ?)");
                        $sqlInsert->bind_param("iiss", $aluno, $livro, $data_hoje, $DezDia);
                        $sqlInsert->execute();
  
                        //Função para tranferencia de dados -> tabela registro
                        $sqlInsert2 = $conn->prepare("INSERT INTO registro(cod_aluno, cod_livro, data_da_reserva, data_da_entrega) VALUES(?, ?, ?, ?)");
                        $sqlInsert2->bind_param("iiss", $aluno, $livro, $data_hoje, $DezDia);
                        $sqlInsert2->execute();
  
                        //Função para excluir dados das tabela temporaria
                        $sqlDelete = $conn->prepare("DELETE FROM reserva_temp WHERE id_temp = $id_temp");
                        $sqlDelete->execute();                    
                          
                        //Função atualizar tabela livro qtd_temp
                        $sqlUpdate = $conn->prepare("UPDATE livro SET qtd_temp = qtd_temp -1 WHERE id_livro = $livro");
                        $sqlUpdate->execute();
  
                        //Função atualizar tabela livro qtd_reserva
                        $sqlUpdate2 = $conn->prepare("UPDATE livro SET qtd_reserva = qtd_reserva +1 WHERE id_livro = $livro");
                        $sqlUpdate2->execute();
  
                        header('location: registros-reservas-temp.php?status=success');

                    }else{

                        //Função para tranferencia de dados -> tabela reserva
                        $sqlInsert = $conn->prepare("INSERT INTO reserva(cod_aluno, cod_livro, data_da_reserva,	data_da_entrega) VALUES(?, ?, ?, ?)");
                        $sqlInsert->bind_param("iiss", $aluno, $livro, $data_hoje, $DezDia);
                        $sqlInsert->execute();

                        //Função para tranferencia de dados -> tabela registro
                        $sqlInsert2 = $conn->prepare("INSERT INTO registro(cod_aluno, cod_livro, data_da_reserva, data_da_entrega) VALUES(?, ?, ?, ?)");
                        $sqlInsert2->bind_param("iiss", $aluno, $livro, $data_hoje, $DezDia);
                        $sqlInsert2->execute();

                        //Função para excluir dados das tabela temporaria
                        $sqlDelete = $conn->prepare("DELETE FROM reserva_temp WHERE id_temp = $id_temp");
                        $sqlDelete->execute();                    
                        
                        //Função atualizar tabela livro qtd_temp
                        $sqlUpdate = $conn->prepare("UPDATE livro SET qtd_temp = qtd_temp -1 WHERE id_livro = $livro");
                        $sqlUpdate->execute();

                        //Função atualizar tabela livro qtd_reserva
                        $sqlUpdate2 = $conn->prepare("UPDATE livro SET qtd_reserva = qtd_reserva +1 WHERE id_livro = $livro");
                        $sqlUpdate2->execute();

                        header('location: registros-reservas-temp.php?status=success');
                    }

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