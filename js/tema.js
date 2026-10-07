// Fólio — comportamentos visuais compartilhados por todas as páginas
document.addEventListener("DOMContentLoaded", () => {
  marcarPaginaAtual();
  revelarAoRolar();
});

// Destaca no menu o link da página atual
// (as páginas de cada escola literária destacam "Escolas Literárias")
function marcarPaginaAtual() {
  const links = document.querySelectorAll("header .navbar a");
  if (!links.length) return;

  const pasta = (url) => new URL(url, location.href).pathname.split("/").slice(-2, -1)[0];
  const atual = pasta(location.href);
  const escolas = ["quinhentismo", "barroco", "arcadismo", "romantismo", "realismo", "naturalismo",
                   "parnasianismo", "simbolismo", "pre-modernismo", "modernismo", "pos-modernismo"];
  const alvo = escolas.includes(atual) ? "escolas" : atual === "publico" ? "forum" : atual;

  links.forEach((a) => {
    if (pasta(a.href) === alvo) {
      a.classList.add("ativo");
      a.setAttribute("aria-current", "page");
    }
  });
}

// Faz os blocos da página surgirem suavemente conforme aparecem na tela
function revelarAoRolar() {
  if (!("IntersectionObserver" in window)) return;
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  // Blocos que surgem sozinhos
  const blocos = document.querySelectorAll(
    ".containerr, .carousel-container > .text, .carta-container, .conteudo-carta, " +
    ".forum-header, .filtro-container, .perfil-card, .meus-topicos, .sobre-nos > *, " +
    ".equipe h3, .heading, .wrapper > .titulo-card, .pagination, .resposta, .pdt > h3"
  );
  // Grupos cujos itens surgem em sequência (efeito cascata)
  const grupos = document.querySelectorAll(
    ".carousel, .cards-grid, .cards-container, .lista-topicos, .authors-gallery, .carrossel-inner"
  );

  const observador = new IntersectionObserver((entradas) => {
    entradas.forEach((entrada) => {
      if (!entrada.isIntersecting) return;
      const alvo = entrada.target;
      if (alvo.dataset.grupo) {
        [...alvo.children].forEach((filho) => filho.classList.add("visivel"));
      } else {
        alvo.classList.add("visivel");
      }
      observador.unobserve(alvo);
    });
  }, { threshold: 0.12, rootMargin: "0px 0px -40px 0px" });

  blocos.forEach((el) => {
    if (el.getBoundingClientRect().top < window.innerHeight) return; // já visível ao abrir
    el.classList.add("revelar");
    observador.observe(el);
  });

  grupos.forEach((grupo) => {
    if (grupo.getBoundingClientRect().top < window.innerHeight) return;
    grupo.dataset.grupo = "1";
    [...grupo.children].forEach((filho, i) => {
      filho.classList.add("revelar");
      filho.style.setProperty("--atraso", `${Math.min(i, 8) * 0.08}s`);
    });
    observador.observe(grupo);
  });
}
