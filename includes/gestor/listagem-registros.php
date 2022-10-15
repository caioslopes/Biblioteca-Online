<?php

  /* Pega a tabela alunos e a tabela registros e relacionas as informações */
  $querySelect = $conn->prepare("SELECT aluno.id_aluno, aluno.nome_aluno, livro.id_livro, livro.titulo, registro.* 
  FROM registro 
  LEFT JOIN aluno
  ON registro.cod_aluno = aluno.id_aluno
  LEFT JOIN livro
  ON registro.cod_livro = livro.id_livro");
  $querySelect->execute();
  $resultQuerySelect = $querySelect->get_result();

?>

<section class="container-xl corpo">

    <div class="titulo-pagina">
        <h1>Registros</h1>
    </div>

     <div class="table-livros mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aluno</th>
                        <th scope="col">Livro</th>
                        <th scope="col">Data Reserva</th>
                        <th scope="col">Data Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    /* Retorna num array as informações da função acima */
                    while ($registro = mysqli_fetch_assoc($resultQuerySelect)) {
                    ?>
                        <tr>
                            <td><?php echo $registro['id_registro'] ?></td>
                            <td><?php echo $registro['nome_aluno'] ?></td>
                            <td><?php echo $registro['titulo'] ?></td>
                            <td><?php echo $registro['data_da_reserva'] ?></td>
                            <td><?php echo $registro['data_da_entrega'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</section>