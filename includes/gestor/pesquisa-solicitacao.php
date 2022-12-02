
<section class="container-xl mt-100px corpo">

    <div class="d-flex justify-content-between titulo-pagina">
        <div class="titulo-index">
            <span>Resultado da pesquisa</span>
        </div>
        <div class="caixa-busca">
            <form class="d-flex" role="search" method="POST">
                <input class="form-control me-2" type="search" name="busca" placeholder="Buscar Registro"  value="<?php if (isset($_POST['busca'])){ echo $_POST['busca']; } ?>">
                <button class="btn btn-busca-regis" type="submit">Buscar Registro</button>
            </form>
        </div>
    </div>
   <!-- Resultado da pesquisa do usuario -->
    <?php
        if(!empty($_POST['busca'])) { 
            //Pega o valor digitado pelo usuario na barra de pesquisa
            $busca = $_POST['busca'];    

            //Selecionando informações do banco segundo o que o usuario digitou
            $SelectBusca = $conn->prepare("SELECT *,DATE_FORMAT(data_hoje,'%d/%m/%Y') 
            AS data_hojef,
            DATE_FORMAT(data_amanha, '%d/%m/%Y')
            AS data_amanhaf
            FROM reserva_temp
            INNER JOIN livro
            ON id_livro = reserva_temp.cod_livro
            INNER JOIN aluno
            ON id_aluno = reserva_temp.cod_aluno
            WHERE nome_aluno LIKE '%$busca%' OR titulo LIKE '%$busca%';");
            $SelectBusca->execute();
            $resultBusca = $SelectBusca->get_result();
        
        if($resultBusca->num_rows == 0){ ?>
                <div class="nenhum-resultado alert alert-warning">
                    <span>Nenhum resultado encontrado</span>
                    <a class="btn btn-padrao" href="registros-reservas-temp.php">Solicitações</a>
                </div>

       <?php  }else { ?>
                <div class="table-livros mt-4">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th scope="col" class="mobile-non-display">#</th>
                                <th scope="col">Aluno</th>
                                <th scope="col">Livro</th>
                                <th scope="col" class="mobile-non-display">Data Reserva</th>
                                <th scope="col" class="mobile-non-display">Data Entrega</th>
                                <th scope="col">Dar Baixa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* Retorna num array as informações da função acima */
                            while ($reserva = mysqli_fetch_assoc($resultBusca)) {
                            ?>
                                <tr>
                                    <td class="mobile-non-display"><?php echo $reserva['id_temp'] ?></td>
                                    <td><?php echo $reserva['nome_aluno'] ?></td>
                                    <td><?php echo $reserva['titulo'] ?></td>
                                    <td class="mobile-non-display"><?php echo $reserva['data_hojef'] ?></td>
                                    <td class="mobile-non-display"><?php echo $reserva['data_amanhaf'] ?></td>
                                    <td>
                                        <a href='confirmar-reserva-temp.php?id_temp=<?php echo $reserva['id_temp'] ?>' class='btn btn-sm btn-primary'>
                                            Confirmar
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
       
   <?php }}else{ ?>
                <div class="nenhum-resultado alert alert-primary">
                    <span>Pesquise alguma coisa :)</span>   
                    <a class="btn btn-padrao" href="registros-reservas-temp.php">Solicitações</a>
                </div>
 <?php  } ?>
</section>