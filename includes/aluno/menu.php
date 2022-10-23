
<style>
#menu{
    background: #23232e;
    width: 200px;
    height:100%;
    position: absolute;
    top: 0px;

    transition: transform 1s;
}
#fechar{
    display: block;
    border: unset;
    background: unset;
    color: white;
}
.mostrar{
    transform: translateX(100%);
}
.mobile{
    left: -200px;
}
.menu-content{
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 90%;
}
.menu-content-first{
  display: flex;
  flex-direction: column;
  font-size: 17px;
}
.menu-content-second{
  padding: 10px;
}
.titulo-site{
  font-size: 20px;
  padding: 0 10px;
  font-weight: 900;
  color: white;
}
.btn-menu{
  display: flex;
  gap: 10px;
  color: white;
  padding: 10px;
}
.btn-menu:hover{
  color: aqua;
  background-color: white;
}
</style>

  <div id="menu">
    <div class="d-flex justify-content-between align-items-center mt-3">
      <span class="titulo-site">BIBLIOTECA</span>
        <button id="fechar" style="display: none;">
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
          </svg>
        </button>
    </div>
      <div class="menu-content">
        <div class="menu-content-first">
          <a class="btn-menu" href="home.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
            <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
            </svg>
            Inicio
          <a class="btn-menu" href="livros.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-book-fill" viewBox="0 0 16 16">
            <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
            </svg>
            Livros
          </a>
          <a class="btn-menu" href="perfil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            </svg>
            Perfil
          </a>
        </div>
        <div class="menu-content-second">
          <a class="btn btn-danger" href="sair.php">Sair</a>
        </div>
      </div>
  </div>

<script>

  var abrir = document.getElementById("abrir");
  var fechar = document.getElementById("fechar");
  var menu = document.getElementById("menu");

  ajuste();
  window.onresize = ajuste;
  function ajuste(){
      // se a largura da tela for menor que 500 pixeis, a pagina foi aberta em um celular
      if(window.innerWidth < 500){
          // esconde o menu
          menu.classList.add("mobile");

          // mostra os dois botões
          abrir.style.display = "block";
          fechar.style.display = "block";
      } else{
          // mostra o menu
          menu.classList.remove("mobile");
          menu.classList.remove("mostrar");

          // esconde os dois botões
          abrir.style.display = "none";
          fechar.style.display = "none";
      }
  }

  // quando clicar em um botão, abra ou feche o menu
  abrir.onclick = () => menu.classList.add("mostrar");
  fechar.onclick = () => menu.classList.remove("mostrar");
</script>