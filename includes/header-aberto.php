<!-- Abrindo a pagina -->
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca</title>


    <!-- AOS CSS -->
     <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
     <!-- Link Swiper's CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
    />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="css/main.css">
    <style>
      .content-login{
        border-radius: 20px;
        background-color: white;
        display: flex;
        gap: 15px;
        padding: 0px 40px;
      }
      .content-login a{
        font-weight: 900;
      }
       .content-login a:hover{
        cursor: pointer;
       }
    </style>
  </head>
  <body>
   <!-- As a heading -->
<nav class="navbar navbar-expand-lg header-aberto">
  <div class="container-fluid container-xl">
    <a class="navbar-brand text-light" href="index.php">BIBLIOTECA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active text-light" aria-current="page" href="index.php#apresentacao">Sobre o Projeto</a>
        <a class="nav-link text-light" href="index.php#como-funciona">Como Funciona?</a>
        <a class="nav-link text-light" href="index.php#quem-somos">Quem somos?</a>
      </div>
      <div class="navbar-nav content-login">
        <a class="nav-link" href="livros.php">Livros</a>
        <a class="nav-link" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Login</a>
        <a class="nav-link" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Cadastre-se</a>
      </div>
    </div>
  </div>
</nav>
