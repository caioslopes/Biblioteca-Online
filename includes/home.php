<?php
    //Login Aluno
    //Função que valida os dados enviados pelo usuario
    if(isset($_POST['email_Aluno']) || isset($_POST['senha_Aluno'])){
        if (strlen($_POST['email_Aluno']) == 0) {
        header('location: index.php?=status=error');
    } else if (strlen($_POST['senha_Aluno']) == 0) {
        header('location: index.php?=status=error');
    }else {
        //Pega os valores inseridos pelo usuario e passa um filtro para retonar apenas string (segurança)
        $email_aluno = $conn->real_escape_string($_POST['email_Aluno']);
        $senha_aluno = $conn->real_escape_string($_POST['senha_Aluno']);

        //Monta a query que verifica se há um login digitado
        $querySelectAluno = $conn->prepare("SELECT * FROM aluno WHERE email = ? AND senha = ?");
        //Separa os valores inseridos da query (segurança)
        $querySelectAluno->bind_param("ss", $email_aluno, $senha_aluno);
        //Executa a query
        $querySelectAluno->execute();
        //Pegar o valor retonado da query
        $resulQuerySelectAluno = $querySelectAluno->get_result();

        //Verifica o numero de linhas retonardo pega varaivel $resultQuerySelectAluno
        $Num_LinhasAluno = $resulQuerySelectAluno->num_rows;

        //Se o numero for igual a 1, vai ser criado uma sessão caso contrario sera redirecionado para a pagina index.php
        if($Num_LinhasAluno == 1){

            $aluno = $resulQuerySelectAluno->fetch_assoc();

            if(!isset($_SESSION)){
                session_start();
            }

            $_SESSION['id_aluno'] = $aluno['id_aluno'];
            
            header('location: View-Aluno/home.php?=status=success_aluno');
            exit;

        }
    }

    };

    //Login Gestor
    //Função que valida os dados enviados pelo usuario
    if (isset($_POST['usuario_Gestor']) || isset($_POST['senha_Gestor'])) {

    if (strlen($_POST['usuario_Gestor']) == 0) {
         header('location: index.php?=status=error');
    } else if (strlen($_POST['senha_Gestor']) == 0) {
         header('location: index.php?=status=error');
    } else {

        $usuario_gestor = $conn->real_escape_string($_POST['usuario_Gestor']);
        $senha_gestor = $conn->real_escape_string($_POST['senha_Gestor']);

        //Monta a query que verifica se há um login digitado
        $querySelectGestor = $conn->prepare("SELECT * FROM gestor WHERE usuario = ? AND senha = ?");
        //Separa os valores inseridos da query (segurança)
        $querySelectGestor->bind_param("ss", $usuario_gestor, $senha_gestor);
        //Executa a query
        $querySelectGestor->execute();
        //Pegar o valor retonado da query
        $resulQuerySelectGestor = $querySelectGestor->get_result();

        //Verifica o numero de linhas retonardo pega varaivel $resultQuerySelectGestor
        $Num_LinhasGestor = $resulQuerySelectGestor->num_rows;

        //Se o numero for igual a 1, vai ser criado uma sessão caso contrario sera redirecionado para a pagina index.php
        if ($Num_LinhasGestor == 1) {

            $gestor = $resulQuerySelectGestor->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id_gestor'] = $gestor['id_gestor'];

            header('location: View-Gestor/home.php?=status=success_gestor');
        } else {
            header('location: index.php?=status=error');
            exit;
        }
    }
}



?>

<div class="d-flex container-xl">
<section class="mt-3">
    <div style="width: 900px; height: 500px; background-color: blue;">
        <h1>Carrossel</h1>
    </div>
</section>

<section class="m-3">
    
    <section class="container">
        <div class="">
            <label style="margin-right:10px;" for="">Quem está logando?</label>
            <select name="pessoa" id="pessoa">
                <option value="aluno">Aluno</option>
                <option value="gestor">Gestor</option>
            </select>
        </div>
    </section>

    <!-- Formulario de Login do Aluno -->
    <form method="POST" id="formAluno">
        <h4>Aluno</h4>
        <div class="mt-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" name="email_Aluno">
        </div>
        <div class="mt-3">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha_Aluno">
        </div>

        <div class="mt-3">
            <input class="btn btn-primary" type="submit" name="logar_Aluno">

            <a class="btn btn-success" href="cadastrar-aluno.php">
                Cadastrar-se
            </a>
        </div>
    </form>

    <!-- Formulario de Login do Gestor -->
    <form method="POST" style="display: none;" id="formGestor">
    <h4>Gestor</h4>
        <div class="mt-3">
            <label class="form-label">Usuario</label>
            <input class="form-control" type="text" name="usuario_Gestor">
        </div>
        <div class="mt-3">
            <label class="form-label">Senha</label>
            <input class="form-control" type="password" name="senha_Gestor">
        </div>

        <div class="mt-3">
            <input class="btn btn-primary" type="submit" name="logar_Gestor">
        </div>
    </form>
</section>

 <script>
    var select = document.getElementById("pessoa");

    select.oninput = () => {
        if(select.value == "gestor"){
            document.getElementById("formAluno").style.display = "none";
            document.getElementById("formGestor").style.display = "block";
        } else{
            document.getElementById("formAluno").style.display = "block";
            document.getElementById("formGestor").style.display = "none";
        }
    };
</script>