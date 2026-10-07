<?php
require_once __DIR__ . '/../conexao.php';

$pesquisa = $_GET['q'] ?? '';
$pesquisa_sql = "%$pesquisa%";

$epocas = [
    "Quinhentismo",
    "Barroco",
    "Arcadismo",
    "Romantismo",
    "Realismo",
    "Naturalismo",
    "Parnasianismo",
    "Simbolismo",
    "Pré-Modernismo",
    "Modernismo",
    "Pós-Modernismo"
];

ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Obras Literárias</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" href="../escolas/img/logo.png" type="image/png">
  <!-- Bootstrap CSS apenas para grid e utilitários -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style-obras.css" />

  <!-- Ícones -->
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="../css/tema.css" />
  <script src="../js/tema.js" defer></script>
</head>
<style>
  .logo {
  margin-top: -15px;
  display: flex;
  align-items: center;
  font-family: "Quicksand", sans-serif; /* mesma da navbar */
  font-weight: 700;
  font-size: 1rem; /* mesmo tamanho do texto da navbar */
  color: white;
  text-transform: uppercase;
  text-decoration: none;
}

.logo img {
  width: 40px;
  margin-right: 8px;
}

.logo:hover {
  color: var(--main-color);
  transition: color 0.3s ease;
}
header {
  margin-top: 25px;     /* Aumenta o espaço no topo */
  padding-top: 10px;
}
.header .navbar {
  all: unset;
  display: flex !important;
}

</style>
<body>

<header>
   <a class="logo"><img src="../escolas/img/logo.png" alt="Logo" />Fólio</a>
   <div class="bx bx-menu" id="menu-icon"></div>
   <ul class="navbar">
       <li><a href="../carta/carta.html">Home</a></li>
       <li><a href="../escolas/escolas.html">Escolas Literárias</a></li>
       <li><a href="../obras/obras.php">ACERVO LITERÁRIO</a></li>
       <li><a href="../forum/forum.php" class="active">Fórum</a></li>
       <li><a href="../perfil/perfil.php">Minha Conta</a></li>
       <li><a href="../sobre/sobre.php">Sobre</a></li>
   </ul>
</header>

<section class="home" id="home">
<div class="pesquisa-overlay">
<h2>Acervo Literário</h2>
<form id="formPesquisa" method="GET" action="obras.php" class="campo-pesquisa">
    <input type="text" name="q" id="campoPesquisa" placeholder="Pesquise Aqui..." value="<?= htmlspecialchars($pesquisa) ?>">
    <button type="submit" class="botao-pesquisa"><i class="fa-solid fa-magnifying-glass"></i></button>
</form>
</div>
</section>

<?php
function gerarCard($obra) {
    $capa = !empty($obra['capa']) ? htmlspecialchars($obra['capa']) : '../imagens/sem-imagem.svg';
    return '
    <li class="card">
        <div class="img">' .
        (!empty($obra['capa']) ? '<img src="' . $capa . '" alt="Capa" draggable="false">' : '<div class="capa text-muted">Sem capa</div>') .
        '</div>
        <a href="#" class="button abrir-modal"
            data-id="'.$obra['id'].'"
            data-titulo="'.htmlspecialchars($obra['titulo']).'"
            data-descricao="'.htmlspecialchars($obra['descricao']).'"
            data-capa="'.$capa.'"
            data-arquivo="'.htmlspecialchars($obra['arquivo'] ?? '').'">
            Leia mais
        </a>
    </li>';
}

if (empty($pesquisa)) {
    foreach ($epocas as $epoca) {
        $sql = "SELECT * FROM obras WHERE escola_literaria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $epoca);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<h2 class="titulo-card">' . htmlspecialchars($epoca) . '</h2>';
            echo '<hr class="divisoria-card">';
            echo '<div class="wrapper">';
            echo '<i class="arrow left fa-solid fa-angle-left"></i>';
            echo '<ul class="carousel">';

            while ($obra = $result->fetch_assoc()) echo gerarCard($obra);

            echo '</ul>';
            echo '<i class="arrow right fa-solid fa-angle-right"></i>';
            echo '</div>';
        }
    }
} else {
    $sql = "SELECT * FROM obras WHERE titulo LIKE ? OR autor LIKE ? OR escola_literaria LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $pesquisa_sql, $pesquisa_sql, $pesquisa_sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="wrapper" id="obras">';
        echo '<i class="arrow left fa-solid fa-angle-left"></i>';
        echo '<h2 class="titulo-card">Resultados da pesquisa</h2>';
        echo '<hr class="divisoria-card">';
        echo '<ul class="carousel">';

        while ($obra = $result->fetch_assoc()) echo gerarCard($obra);

        echo '</ul>';
        echo '<i class="arrow right fa-solid fa-angle-right"></i>';
        echo '</div>';
    } else {
        echo '<p class="text-center mt-5">Nenhuma obra encontrada para "' . htmlspecialchars($pesquisa) . '".</p>';
    }
}
?>

<!-- Modal customizado -->
<div class="modal-obra" id="infoModal" style="display: none;">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <h2 id="modalTitulo"></h2>
    <div class="modal-body">
      <img id="modalCapa" class="modal-capa" src="" alt="Capa">
      <div class="modal-texto" id="modalTexto"></div>
    </div>
    <div id="areaBotoes" class="d-flex gap-2"></div>
  </div>
</div>
<br/>
<br/>

<section class="footer-section">
      <br />
      <footer class="footer">
        <div class="footer-container">
          <!-- NAVEGAÇÃO -->
          <div class="footer-col">
            <p class="qrp">Baixe o app</p>
         <a class="qr"><img src="../imagens/qr.png" alt="img" /> </a>
          </div>
          <!-- CONTEXTO HISTÓRICO -->
          <div class="footer-col">
            <h5>ESCOLAS LITERÁRIAS</h5>
            <ul>
              <li>
                <a href="../quinhentismo/quinhentismo.php">Quinhentismo</a>
              </li>
              <li><a href="../barroco/barroco.php">Barroco</a></li>
              <li><a href="../arcadismo/arcadismo.php">Arcadismo</a></li>
              <li><a href="../romantismo/romantismo.php">Romantismo</a></li>
              <li><a href="../realismo/realismo.php">Realismo</a></li>
              <li><a href="../naturalismo/naturalismo.php">Naturalismo</a></li>
              <li>
                <a href="../parnasianismo/parnasianismo.php">Parnasianismo</a>
              </li>
              <li><a href="../simbolismo/simbolismo.php">Simbolismo</a></li>
              <li>
                <a href="../pre-modernismo/pre-modernismo.php"
                  >Pré-Modernismo</a
                >
              </li>
              <li><a href="../modernismo/modernismo.php">Modernismo</a></li>
              <li>
                <a href="../pos-modernismo/pos-modernismo.php"
                  >Pós-Modernismo</a
                >
              </li>
            </ul>
          </div>

          <!-- OBRAS -->
          <div class="footer-col">
            <h5>ACERVO LITERÁRIO</h5>
            <ul>
              <li><a href="../obras/obras.php">Livros</a></li>
               
            </ul> <br> 
                 <h5>NAVEGAÇÃO</h5>
            <ul>
              <li><a href="../carta/carta.html">HOME</a></li>
              <li><a href="../forum/forum.php">FÓRUM</a></li>
              <li><a href="../sobre/sobre.php">SOBRE O SITE</a></li>
              <li><a href="../perfil/perfil.php">MINHA CONTA</a></li>
            </ul>
          </div>

         
             <div class="footer-col">
            <h5>FALE CONOSCO</h5>
            <form id="contatoForm" method="POST" action="../enviar_email.php">
              <label for="emailContato">Email</label>
              <input
                type="email"
                name="emailContato"
                id="emailContato"
                placeholder="Seu email"
                required
              />

              <label for="mensagemContato">Mensagem</label>
              <textarea
                name="mensagemContato"
                id="mensagemContato"
                rows="3"
                placeholder="Digite sua mensagem"
                required
                style="color: black; background-color: #fff"
              ></textarea>

              <button type="submit">Enviar</button>
            </form>

            <!-- Mensagem de retorno (sem interferir no layout) -->
            <div
              id="resultadoContato"
              style="margin-top: 8px; font-size: 0.9rem"
            ></div>
          </div>
        </div>
      </footer>
      <br />
    </section>
<div class="footer-bottom">
    <small>&copy; 2025 Fólio. Todos os direitos reservados.</small>
</div>


<button id="backToTop" title="Voltar ao topo" aria-label="Voltar ao topo">
  <i class="fa-solid fa-arrow-up"></i>
</button>

<script>
  // Mostrar botão quando descer a página
  window.onscroll = function() {
    const btn = document.getElementById("backToTop");
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
      btn.style.display = "block";
    } else {
      btn.style.display = "none";
    }
  };

  // Scroll suave ao topo
  document.getElementById("backToTop").addEventListener("click", function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  document.getElementById("contatoForm").addEventListener("submit", async function(e) {
    e.preventDefault(); // evita recarregar a página

    const formData = new FormData(this);

    try {
        const response = await fetch("../enviar_email.php", { method: "POST", body: formData });
        const texto = (await response.text()).trim();

        if (texto === "success") {
            alert("✅ Mensagem enviada com sucesso!");
            this.reset(); // limpa o formulário
        } else {
            alert("❌ Ocorreu um erro ao enviar. Tente novamente.");
        }
    } catch (err) {
        alert("❌ Erro de conexão. Tente novamente.");
        console.error(err);
    }
});
</script>
<!-- SCRIPT DO MODAL -->
<script>
  
const modal = document.getElementById('infoModal');
const closeModal = modal.querySelector('.close-modal');

document.querySelectorAll('.abrir-modal').forEach(button => {
  button.addEventListener('click', e => {
    e.preventDefault();

    const titulo = button.dataset.titulo || '';
    const descricao = button.dataset.descricao || '';
    const capa = button.dataset.capa || '';
    const arquivo = button.dataset.arquivo || '';

    document.getElementById('modalTitulo').textContent = titulo;
    document.getElementById('modalTexto').innerHTML = `<p>${descricao}</p>`;
    document.getElementById('modalCapa').src = capa;

    const botoes = document.getElementById('areaBotoes');
    botoes.innerHTML = '';

    if (arquivo && arquivo.trim() !== '') {
      botoes.innerHTML = `<a href="${arquivo}" download id="botaoDownload" class="btn btn-success">Baixar Arquivo</a>`;
    } else {
      botoes.innerHTML = `<button class="btn btn-primary" id="btnBiblioteca">Procurar em uma Biblioteca</button>`;
      setTimeout(()=> {
        const btn = document.getElementById('btnBiblioteca');
        if (btn) btn.onclick = () => window.open('https://www.google.com/maps/search/biblioteca+perto+de+mim','_blank');
      }, 50);
    }

    modal.style.display = 'flex';
  });
});

closeModal.addEventListener('click', () => {
  modal.style.display = 'none';
});

// Fechar modal ao clicar fora do conteúdo
window.addEventListener('click', e => {
  if(e.target === modal) modal.style.display = 'none';
});
</script>

<!-- SCRIPT DO CARROSSEL -->
<script>
document.querySelectorAll(".wrapper").forEach(wrapper => {
  const carousel = wrapper.querySelector(".carousel");
  const firstCardWidth = carousel.querySelector(".card") ? carousel.querySelector(".card").offsetWidth : 0;
  const arrowBtns = wrapper.querySelectorAll("i.arrow");

  arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      carousel.scrollLeft += btn.classList.contains("left") ? -firstCardWidth : firstCardWidth;
    });
  });

  let isDragging = false, startX, startScrollLeft;

  const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
  };

  const dragging = (e) => {
    if (!isDragging) return;
    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
  };

  const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
  };

  carousel.addEventListener("mousedown", dragStart);
  carousel.addEventListener("mousemove", dragging);
  document.addEventListener("mouseup", dragStop);
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const pesquisa = urlParams.get("q");

    // Se tiver pesquisa e existir o container #obras, rola até ele
    if (pesquisa && pesquisa.trim() !== "") {
        const resultados = document.getElementById("obras");
        if (resultados) {
            setTimeout(() => {
                resultados.scrollIntoView({ behavior: "smooth", block: "start" });
            }, 300);
        }
    }
});
</script>
<script>
const menuIcon = document.querySelector("#menu-icon");
const navbar   = document.querySelector(".navbar");

menuIcon.onclick = () => {
  navbar.classList.toggle("active");
  menuIcon.classList.toggle("bx-x"); // vira X
};
</script>

</body>
</html>
