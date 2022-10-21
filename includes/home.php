<?php 

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
<style>
    .bg-apresentacao{
        background-color: #23232e;
        height: 100vh;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        gap: 60px;
    }
    .card-apresentacao{
        background-color: white;
        border-radius: 10px;
        width: 300px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 15px;
        box-shadow: 3px 3px 2px 2px #b7b7b7;
    }
    .card-apresentacao span:first-child{
        font-weight: bold;
        font-size: 24px;
    }
    .bg-titulo-apres{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }
    .bg-titulo-apres span:first-child{
        font-size: 80px;
        font-weight: 900;
    }
    .bg-titulo-apres span:not(:first-child){
        font-size: 30px;
        font-weight: bold;
    }
    .bg-cards-apres{
        gap: 70px;
    }
    /* Sessão como funciona? */
    .bg-como-funciona{
        background-color: #f5f5f5;
    }
    .bg-titulo-como-fun span{
        font-size: 60px;
        font-weight: 900;
        text-align: center;
        display: flex;
        justify-content: center;
        padding: 50px 0;
    }
    .card-como-fun{
        background-color: #23232e;
        color: white;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        text-align: start;
        width: 600px;
        padding: 20px;
        box-shadow: 1px 1px 3px 2px #b7b7b7;
    }
    .card-como-fun:nth-child(1){
        position: relative;
        left: -230px;
    }
    .card-como-fun:nth-child(3){
        position: relative;
        left: 230px;
    }
    .card-como-fun span:first-child{
        font-size: 24px;
        font-weight: bold;
    }
    .card-como-fun span:nth-child(2){
        font-size: 18px;
    }
    .bg-cards-como-fun{
        display: flex;
        flex-direction: column;
        gap: 30px;
        justify-content: center;
        align-items: center;
        padding-bottom: 70px;
    }
    /* Sessão quem somos? */
    .bg-quem-somos{
        background-color: #23232e;
        height: 700px;
    }
    .bg-titulo-quem-somos span{
        font-size: 60px;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 50px 0;
    }
    .integrantes img{
        width: 250px;
    }
    /* Alterações icones svg */
    .gear-plus{
        position: relative;
        left: 5px;
        rotate: 35deg;
    }
    .gear-little{
        position: relative;
        top: -16px;
    }

    /* integrantes */
    .card-integrantes{
        display: flex;
        flex-direction: column;
    }
    .card-integrantes span{
        padding-top: 10px;
        text-align:center; 
        color: white;
    }
    .card-integrantes:hover{
        opacity: 0.7;
    }
</style>
<section>
    <?=$msg?>
    <div id="apresentacao" class="bg-apresentacao">
        <div class="bg-titulo-apres">
            <span>Biblioteca Online</span>
            <span>Um projeto para tornar digital todas as atividades da biblioteca escolar</span>
        </div>
        <div class="d-flex align-items-center justify-content-center bg-cards-apres">
            <div class="card-apresentacao">
                <span>ACESSO</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
                </svg>
                <span>Para acessar os livros disponiveis 
                    na biblioteca da escola basta acessar 
                    a página livros.</span>
            </div>
            <div class="card-apresentacao">
                <span>ADMINISTRAÇÃO</span>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-gear-fill gear-plus" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-gear-fill gear-little" viewBox="0 0 16 16">
                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                    </svg>
                </div>
                <span>No sistema do gestor é possivel  
                cadastrar, editar ou excluir um livro 
                caso necessario.</span>
            </div>
            <div class="card-apresentacao">
                <span>INFORMAÇÃO</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span>As informações agora ficam salvas digitalmente, 
                    quem pegou tal livro, quando pegou etc.</span>
            </div>
        </div>
    </div>

    <div id="como-funciona" class="bg-como-funciona">
        <div class="bg-titulo-como-fun">
            <span>Como Funciona?</span>
        </div>

        <div class="bg-cards-como-fun">
            <div class="card-como-fun" data-aos="fade-left">
                <span>Sistema Aberto</span>
                <span>A primeira parte do site, serve para apresentar o projeto e
                apresentar o catalogo de livros disponiveis na biblioteca de forma 
                livre onde qualquer um possa acessar.</span>
            </div>
            <div class="card-como-fun" data-aos="fade-left">
                <span>Sistema do Aluno</span>
                <span>Para acessar esta parte é preciso fazer o login e caso não tenha 
                    uma conta é preciso cadastrar-se. Nesta parte é apresentado as 
                    informações do aluno como: Quais livros ele pegou e quando é para 
                    entregar; Dados do aluno, e também onde o aluno poderá fazer a 
                    auto-reserva.</span>
            </div>
            <div class="card-como-fun" data-aos="fade-left">
                <span>Sistema do Gestor</span>
                <span>Assim como no sistema do aluno é preciso fazer login, só é possivel 
                    cadastrar um novo usuario dentro do proprio sistema.
                    Aqui será apresentado todas as informações do site, livros 
                    cadastrados, alunos e reservas. Sendo possivel fazer alterações 
                    e novos registros como emprestar um livro.</span>
            </div>
        </div>
    </div>

    <div id="quem-somos" class="bg-quem-somos">
        <div class="bg-titulo-quem-somos">
            <span>Quem Somos?</span>
        </div>

        <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Adrian Ismirael Ballestero Zambuzzi</span>
        </div>
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Caio dos Santos Lopes</span>
        </div>
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Eduardo Pires Carvalho</span>
        </div>
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Gabriel Soares de Souza</span>
        </div>
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Guilherme Crecenzi</span>
        </div>
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Mauro Eduardo Gusmao Andreoli</span>
        </div>
        <div class="swiper-slide card-integrantes">
            <img src="img/integrantes/renata.jpeg" alt="">
            <span>Renata Bueno dos Santos</span>
        </div>
      </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
    </div>
</section>


     <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
     <!-- Initialize Swiper -->
    <script>        
         AOS.init({
            duration: 2000,
         });
      var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 30,
        loop: true,
         autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
      });
    </script>
