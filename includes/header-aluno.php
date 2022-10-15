<!-- Abrindo a pagina -->
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
    <nav class="navbar header-geral">
        <div class="d-flex justify-content-end container-xl">
          <?php

            if(isset($_SESSION['id_aluno'])){
              $id_aluno = $_SESSION['id_aluno'];

              $querySelectAluno = $conn->prepare("SELECT nome_aluno, email FROM aluno WHERE id_aluno = $id_aluno");
              $querySelectAluno->execute();
              $resultSelectAluno = $querySelectAluno->get_result();

              while($aluno = mysqli_fetch_assoc($resultSelectAluno)){
                  $nome_aluno = $aluno['nome_aluno'];
                  $email_aluno = $aluno['email'];
              };
              ?> 
              <div class="btn-group">
                <button type="button" class="btn btn-secondary"><?php echo $nome_aluno ?></button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent">
                  <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="sair.php">Sair</a></li>
              </div>
              <?php
            }

          ?>
          
        </div>
    </nav>
