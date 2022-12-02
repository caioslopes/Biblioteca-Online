//Gatilho popover boostrap
const popoverTriggerList = document.querySelectorAll(
    '[data-bs-toggle="popover"]'
);
const popoverList = [...popoverTriggerList].map(
    (popoverTriggerEl) => new bootstrap.Popover(popoverTriggerEl)
);

//Swipper Slide
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        "@0.00": {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        "@0.75": {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        "@1.00": {
            slidesPerView: 3,
            spaceBetween: 40,
        },
        "@1.50": {
            slidesPerView: 4,
            spaceBetween: 50,
        },
    },
});

/* Menu */
var abrir = document.getElementById("abrir");
var fechar = document.getElementById("fechar");
var menu = document.getElementById("menu");

ajuste();
window.onresize = ajuste;
function ajuste() {
    // se a largura da tela for menor que 500 pixeis, a pagina foi aberta em um celular
    if (window.innerWidth < 500) {
        // esconde o menu
        menu.classList.add("mobile");

        // mostra os dois botões
        abrir.style.display = "block";
        fechar.style.display = "block";
    } else {
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

//Dropdown menu gestor
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "flex") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "flex";
        }
    });
}

