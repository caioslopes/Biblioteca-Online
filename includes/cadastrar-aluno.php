<?php 

    if(!empty($_POST['cadastrar'])){

        //Pega os valores inserido pelo usuario e armazena numa variavel
        $nome_aluno = $_POST['nome_aluno'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        //Monta a query de inserção no banco de dados
        $queryInsert = $conn->prepare("INSERT INTO aluno (nome_aluno, email, senha) VALUES(?, ?, ?)");
        //Separa os valores inseridos da query
        $queryInsert->bind_param("sss", $nome_aluno, $email, $senha);
        //Executa a query
        $queryInsert->execute();

        header('location: index.php?=status=success');

    }

?>

<section class="container-xl m-auto">
    <div>
        <h2>Cadastrar-se</h2>
    </div>

    <form method="POST">
        <div class="mt-3">
            <label class="form-label">Nome completo</label>
            <input class="form-control" type="text" name="nome_aluno" required>
        </div>
        <div class="mt-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email" required>
        </div>
        <div class="mt-3">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha" required>
        </div>

        <div class="mt-3">
            <input class="btn btn-primary" type="submit" name="cadastrar">

            <a class="btn btn-success" href="login.php">
                Já tenho cadastro
            </a>
        </div>
    </form>
    
</section>