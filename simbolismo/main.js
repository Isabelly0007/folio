let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");

// Toggle menu mobile
menu.onclick = () => {
  menu.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};

// Remove menu ativo ao dar scroll na página
window.onscroll = () => {
  menu.classList.remove("bx-x");
  navbar.classList.remove("active");
};

// Função para bloquear/desbloquear scroll do body ao abrir/fechar modal
function toggleBodyScroll(lock) {
  if (lock) {
    document.body.style.overflow = "hidden";
  } else {
    document.body.style.overflow = "";
  }
}

// Abre o modal correspondente com os dados carregados via AJAX
async function abrirModal(e) {
  e.preventDefault();

  const botao = e.currentTarget;
  const tipo = botao.getAttribute("data-tipo");
  const id = botao.getAttribute("data-id");

  if (!id) {
    alert("ID não encontrado.");
    return;
  }

  // Monta a URL da API para buscar os dados
  const url = `?api=${tipo}&id=${id}`;

  try {
    const response = await fetch(url);
    if (!response.ok) throw new Error("Erro na requisição");
    const data = await response.json();

    if (data.error) {
      alert(data.error);
      return;
    }

    if (tipo === "obra") {
      document.getElementById("tituloObra").innerText =
        data.titulo || "Sem título";
      document.getElementById("descricaoObra").innerText =
        data.descricao || "Sem descrição";
      document.getElementById("capaObra").src = data.capa || "../imagens/sem-imagem.svg";

      const botaoDownload = document.getElementById("botaoDownload");
      if (data.arquivo && data.arquivo.trim() !== "") {
        botaoDownload.href = data.arquivo;
        botaoDownload.target = "_blank";
        botaoDownload.onclick = null;
        botaoDownload.innerText = "Baixar";
        botaoDownload.classList.remove("btn-secondary");
        botaoDownload.classList.add("btn-light");
      } else {
        botaoDownload.href = "#";
        botaoDownload.removeAttribute("target");
        botaoDownload.innerText = "Procurar em bibliotecas";
        botaoDownload.classList.remove("btn-light");
        botaoDownload.classList.add("btn-secondary");
        botaoDownload.onclick = function (e) {
          e.preventDefault();
          if (
            confirm(
              "Esta obra não está disponível para download. Deseja procurar em bibliotecas públicas próximas?"
            )
          ) {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(
                function (pos) {
                  const lat = pos.coords.latitude;
                  const lon = pos.coords.longitude;
                  const mapsUrl = `https://www.google.com/maps/search/biblioteca+publica/@${lat},${lon},14z`;
                  window.open(mapsUrl, "_blank");
                },
                function () {
                  alert("Não foi possível obter sua localização.");
                }
              );
            } else {
              alert("Seu navegador não suporta geolocalização.");
            }
          }
        };
      }
      document.getElementById("modalObra").style.display = "flex";
      toggleBodyScroll(true);
    } else if (tipo === "autor") {
      document.getElementById("tituloAutor").innerText =
        data.nome || "Sem nome";
      document.getElementById("descricaoAutor").innerText =
        data.biografia || "Sem biografia";
      document.getElementById("capaAutor").src =
        data.capa || "../imagens/sem-imagem.svg";

      document.getElementById("modalAutor").style.display = "flex";
      toggleBodyScroll(true);
    }
  } catch (err) {
    alert("Erro ao carregar dados.");
    console.error(err);
  }
}

// Associa o evento a todos os botões "ver mais"
document.querySelectorAll(".ver-mais").forEach((botao) => {
  botao.addEventListener("click", abrirModal);
});

// Função para fechar modais
function fecharModal(idModal) {
  document.getElementById(idModal).style.display = "none";
  toggleBodyScroll(false);
}

// Fecha modal Obra ao clicar no X
document.querySelector(".close-modal-obra").addEventListener("click", () => {
  fecharModal("modalObra");
});

// Fecha modal Autor ao clicar no X
document.querySelector(".close-modal-autor").addEventListener("click", () => {
  fecharModal("modalAutor");
});

// Fecha modal ao clicar fora do conteúdo
window.addEventListener("click", (e) => {
  const modalObra = document.getElementById("modalObra");
  const modalAutor = document.getElementById("modalAutor");

  if (e.target === modalObra) {
    fecharModal("modalObra");
  }
  if (e.target === modalAutor) {
    fecharModal("modalAutor");
  }
});
