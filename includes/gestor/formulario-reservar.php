<?php 

    /* Função que relaciona as tabelas livro e reserva, fazendo uma conta de subtração para retornar quantos livros estão disponiveis */
    $querySelectLivro = $conn->prepare("SELECT * FROM livro");
    $querySelectLivro->execute();
    $resultSelectLivro = $querySelectLivro->get_result();

    /* Pega a tabela alunos e a tabela reserva para relacionar as informações e descobrir o nome e a sala do aluno */
    $querySelectAluno = $conn->prepare("SELECT aluno.id_aluno, 
    aluno.nome_aluno,
    COUNT(reserva.cod_aluno)
    AS livros_reservados
    FROM aluno
    LEFT JOIN reserva
    ON aluno.id_aluno = reserva.cod_aluno
    GROUP BY aluno.id_aluno");
    $querySelectAluno->execute();     
    $resultQueryAluno = $querySelectAluno->get_result();

    if(isset($_POST['emprestar'])){
        $id_aluno = $_POST['aluno'];
        $id_livro = $_POST['livro'];
        $data_da_reserva = $_POST['data_da_reserva'];
        $data_da_entrega = $_POST['data_da_entrega'];

        //Puxa os dados da tabela reserva para podermos verificar se o aluno selecionado já possui algum livro reservado
        $queryVerificaAluno = $conn->prepare("SELECT * FROM reserva WHERE cod_aluno = $id_aluno ");
        $queryVerificaAluno->execute();
        $resultVerificaAluno = $queryVerificaAluno->get_result();

        /* Função que relaciona as tabelas livro e reserva, fazendo uma conta de subtração para retornar quantos livros estão disponiveis */
        $querySelectLivro = $conn->prepare("SELECT * FROM livro WHERE id_livro = $id_livro");
        $querySelectLivro->execute();
        $resultQueryLivro = $querySelectLivro->get_result();

        //Puxa os dados da relação da tabela livro com a tabela reserva para poderos saber a conta de quantos livros estão disponiveis
        while($queryQuantidade = mysqli_fetch_assoc($resultQueryLivro)){
            $qtd_total = $queryQuantidade['qtd_total'];
            $qtd_reserva = $queryQuantidade['qtd_reserva'];
            $qtd_temp = $queryQuantidade['qtd_temp'];
        };

        //Verifica se o aluno que foi selecionado já não está com algum livro reservado.
        if($resultVerificaAluno->num_rows >= 1 ){
          header('location: reservar.php?status=error');
          exit;
        }else if($qtd_reserva + $qtd_temp >= $qtd_total ){
          header('location: reservar.php?status=error');
          exit;
        }else{

          //Inserindo na tabela reserva os dados enviado pelo gestor
            $queryInsertReserva = $conn->prepare("INSERT INTO reserva (cod_aluno, cod_livro, data_da_reserva, data_da_entrega) VALUES (?, ?, ?, ?)");
            $queryInsertReserva->bind_param("iiss", $id_aluno, $id_livro, $data_da_reserva, $data_da_entrega);
            $queryInsertReserva->execute();

            //Inserindo na tabela registro os dados enviado pelo gestor (historico de informação)
            $queryInsertRegistro = $conn->prepare("INSERT INTO registro (cod_aluno, cod_livro, data_da_reserva, data_da_entrega) VALUES (?, ?, ?, ?)");
            $queryInsertRegistro->bind_param("iiss", $id_aluno, $id_livro, $data_da_reserva, $data_da_entrega);
            $queryInsertRegistro->execute();

            //Soma para podermos verificar quantidades
            $sqlInsertQtd = $conn->prepare("UPDATE livro SET qtd_reserva = qtd_reserva +1 WHERE id_livro = $id_livro");
            $sqlInsertQtd->execute();
            
            header('location: livros-reservados.php?status=success');
            exit;
        };



    }

    $msg = '';
    if(isset($_GET['status'])){
        switch ($_GET['status']){
            case 'success';
            $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Ação executada com sucesso!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;

            case 'erro';
            $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Ação não executada!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            break;
        }
    }
?>

<section class="container-xl corpo">

<?=$msg?>

  <div class="titulo-pagina">
    <h1>Emprestar Livro</h1>
  </div>

    <form class="mt-4"  method="POST">
      <div class="form-floating mb-3">
        <select class="form-select" id="aluno" name="aluno" required>
          <option selected>Selecionar Aluno</option>
           <?php
                 /* Retorna num array as informações relaciondas na tabela de alunos acima */
                 while ($aluno = mysqli_fetch_assoc($resultQueryAluno)) {  ?>
                <option <?php if ($aluno['livros_reservados'] >= 1) { ?> disabled <?php  }  ?> value="<?php echo $aluno['id_aluno'] ?>"><?php echo $aluno['nome_aluno'] ?> | <?php echo 'Livros: '. $aluno['livros_reservados']; ?> </option>
            <?php } ?>
        </select>
        <label for="floatingSelect">Aluno</label>
      </div>

      <div class="form-floating mb-3">
        <select class="form-select" id="livro" name="livro" required>
          <option value="Selecione">Selecionar Livro</option>
            <!-- Retorna num array as informações relaciondas na tabela de livros acima -->
            <?php 
                while ($livro = mysqli_fetch_assoc($resultSelectLivro)) {  ?>
                <option value="<?php echo $livro['id_livro'] ?>"> <?php echo $livro['titulo'] ?> </option>
            <?php } ?>
        </select>
        <label for="floatingSelect">Livro</label> 
      </div>

      <div class="input-group mb-3">
        <span class="input-group-text">Data da Reserva</span>
        <input type="date" class="form-control"  id="data_da_reserva" name="data_da_reserva" required>
      </div>

       <div class="input-group mb-3">
        <span class="input-group-text">Data da Devolução</span>
        <input type="date" class="form-control"  id="data_da_entrega" name="data_da_entrega" required>
      </div>

      <div class="mb-3">
          <input type="submit" name="emprestar" class="btn btn-primary" value="Emprestar">
      </div>

    </form>
</section>