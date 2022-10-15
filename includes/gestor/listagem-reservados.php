  <?php

    /* Relaciona a tabela reserva, livro e aluno para podermos mostrar as informações pro gestor */
    $querySelect = $conn->prepare("SELECT * FROM reserva
    INNER JOIN livro
    ON id_livro = reserva.cod_livro
    INNER JOIN aluno
    ON id_aluno = reserva.cod_aluno");
    $querySelect->execute();
    $resultQuerySelect = $querySelect->get_result();

    ?>

<section class="container-xl corpo">

    <div class="titulo-pagina">
        <h1>Livros Emprestados</h1>
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
                        <th scope="col">Dar Baixa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    /* Retorna num array as informações da função acima */
                    while ($reserva = mysqli_fetch_assoc($resultQuerySelect)) {
                    ?>
                        <tr>
                            <td><?php echo $reserva['id_reserva'] ?></td>
                            <td><?php echo $reserva['nome_aluno'] ?></td>
                            <td><?php echo $reserva['titulo'] ?></td>
                            <td><?php echo $reserva['data_da_reserva'] ?></td>
                            <td><?php echo $reserva['data_da_entrega'] ?></td>
                            <td>
                                <a href='dar-baixa-livro.php?id=<?php echo $reserva['id_reserva'] ?>' class='btn btn-sm btn-primary'>
                                    Dar Baixa
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</section>