<?php
    //Função Cadastrar Aluno
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
<style>
        /* Formulario Aluno */
    #formAluno div:nth-child(3){
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
        gap: 15px;
    }
     #formAluno div:nth-child(3) a{
        color: blue;
        text-decoration: underline;
     }
     #formAluno div:nth-child(3) a:hover{
        cursor: pointer;
        color: gray;
     }
     .btn-entrar{
        border-radius: 20px;
        width: 50%;
     }
     .opcao-login label{
        margin-right: 10px;
        font-weight: bold;
        text-decoration: underline;
     }
     .opcao-login select{
        width: 20%;
        border-radius: 20px;
        text-align: center;
        border: 2px solid;
     }
     .modal-body{
        padding: 40px;
     }
     /* Formulario Gestor */
     #formGestor div:nth-child(3){
        display: flex;
        justify-content: center;
     }
     /* Formulario Cadastro */
     #formCadastro div:nth-child(4){
        display: flex;
        flex-direction: column;
        text-align: center;
        gap: 15px;
     }
     #formCadastro div:nth-child(4) input{
        border-radius: 20px;
     }
     #formCadastro div:nth-child(4) a{
        color: blue;
        text-decoration: underline;
     }
     #formCadastro div:nth-child(4) a:hover{
        cursor: pointer;
        color: gray;
     }
</style>
<!-- Modal Login -->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Formulario Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="content-formulario">
        <div class="opcao-login">
            <label>Entrar como:</label>
            <select name="pessoa" id="pessoa">
                <option value="aluno">Aluno</option>
                <option value="gestor">Gestor</option>
            </select>
        </div>
        <!-- Formulario de Login do Aluno -->
        <form method="POST" id="formAluno">
           <!--  <h4>Aluno</h4> -->
            <div class="mt-3">
                <label class="form-label">Email</label>
                <input class="form-control rounded-pill" type="email" name="email_Aluno">
            </div>
            <div class="mt-3">
                <label class="form-label">Senha</label>
                <input class="form-control rounded-pill" type="password" name="senha_Aluno">
            </div>

            <div class="mt-3">
                <input class="btn btn-primary btn-entrar" type="submit" name="logar_Aluno" value="Entrar">
                <a data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Cadastrar-se</a>
            </div>
        </form>

        <!-- Formulario de Login do Gestor -->
        <form method="POST" style="display: none;" id="formGestor">
      <!--   <h4>Gestor</h4> -->
            <div class="mt-3">
                <label class="form-label">Usuario</label>
                <input class="form-control rounded-pill" type="text" name="usuario_Gestor">
            </div>
            <div class="mt-3">
                <label class="form-label">Senha</label>
                <input class="form-control rounded-pill" type="password" name="senha_Gestor">
            </div>

            <div class="mt-3">
                <input class="btn btn-primary btn-entrar" type="submit" name="logar_Gestor" value="Entrar">
            </div>
        </form>
    </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Formulario de Cadastro</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div>
        <h2>Cadastrar-se</h2>
    </div>

    <form method="POST" id="formCadastro">
        <div class="mt-3">
            <label class="form-label">Nome completo</label>
            <input class="form-control rounded-pill" type="text" name="nome_aluno" required>
        </div>
        <div class="mt-3">
            <label class="form-label">Email</label>
            <input class="form-control rounded-pill" type="email" name="email" required>
        </div>
        <div class="mt-3">
            <label class="form-label">Senha</label>
            <input class="form-control  rounded-pill" type="password" name="senha" required>
        </div>

        <div class="mt-3">
            <input class="btn btn-primary" type="submit" name="cadastrar">

            <a data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                Já tenho cadastro
            </a>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>

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