<?php
require_once __DIR__ . '/../conexao.php';
if (isset($_GET['api'])) {

    header('Content-Type: application/json; charset=utf-8');

    $tipo = $_GET['api'];
    $id = intval($_GET['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(["error" => "ID inválido"]);
        exit;
    }

    if ($tipo === 'obra') {
        $sql = "SELECT titulo, descricao, capa, arquivo FROM obras WHERE id = ? LIMIT 1";
    } elseif ($tipo === 'autor') {
        $sql = "SELECT nome, biografia, capa FROM autores WHERE id = ? LIMIT 1";
    } else {
        echo json_encode(["error" => "Tipo inválido"]);
        exit;
    }

    $stmt = $conn->prepare($sql); // atenção: isto só funciona se $conn existir
    if (!$stmt) {
        echo json_encode(["error" => "Erro na preparação: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        echo json_encode($res->fetch_assoc(), JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["error" => "Registro não encontrado"]);
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Romantismo</title>
<link rel="icon" href="../escolas/img/logo.png" type="image/png">
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <link rel="stylesheet" href="../css/tema.css" />
  <script src="../js/tema.js" defer></script>
</head>
<body>
<!-- navbar -->
<header>
    <a class="logo"><img src="../imagens/logo.png" alt="Logo do site" />Fólio</a>
    <div class="bx bx-menu" id="menu-icon"></div>

    <ul class="navbar">
        <li><a href="../carta/carta.html">Home</a></li>
        <li><a href="../escolas/escolas.html">Escolas Literárias</a></li>
        <li><a href="../obras/obras.php">Acervo Literário</a></li>
        <li><a href="../forum/forum.php">Fórum</a></li>
        <li><a href="../perfil/perfil.php">Minha Conta</a></li>
        <li><a href="../sobre/sobre.php">Sobre</a></li>
    </ul>
</header>

<!-- banner -->
<section class="home" id="home">
    <div class="home-text">
        <h1>Romantismo</h1>
        <h2>(1836-1881)</h2>
    </div>
</section>

<div class="onda-container">
    <svg class="onda-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
        <path fill="#740E10" d="M0,32 C360,96 1080,0 1440,64 L1440,0 L0,0 Z"></path>
    </svg>
</div>

<!-- corpo principal -->
<section class="tit" id="tit">
    <div class="containerr clearfix">
        <div class="imagem-flutuante">
            <img src="./img/img_romantismo.png" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>Iracema por José Maria de Medeiros (1849–1925)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p> O Romantismo foi um movimento artístico, literário e filosófico que se desenvolveu inicialmente na Europa, entre o final do século XVIII Sua origem costuma ser associada à publicação de Os Sofrimentos do Jovem Werther (1774), de Johann Wolfgang von Goethe, obra que marcou o início da sensibilidade romântica ao enfatizar a introspecção, a melancolia e os conflitos emocionais do indivíduo. 
</br>
Esse movimento rompeu com os padrões do Neoclassicismo e da tradição greco-romana, afastando-se da razão e da rigidez formal para valorizar a emoção, a liberdade criativa, a imaginação e o subjetivismo. Ele influenciou profundamente não apenas a literatura, mas também a música, a pintura, o teatro e o pensamento filosófico da época. </p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
            <p>O Romantismo nasceu em um contexto de profundas transformações sociais e políticas, como a Revolução Francesa, a Revolução Industrial e o fortalecimento dos ideais nacionalistas. Essas mudanças contribuíram para uma valorização do indivíduo, da liberdade de expressão, das tradições locais e da cultura popular. 
</br>
Em Portugal, o movimento esteve profundamente ligado às tensões políticas entre liberais e absolutistas. A literatura romântica portuguesa buscou resgatar o passado histórico da nação, exaltando suas tradições e glórias. O marco inicial foi o poema Camões (1825), escrito por Almeida Garrett durante seu exílio. Garrett é também autor de Viagens na Minha Terra, uma das obras mais representativas do Romantismo em Portugal, em que mistura narrativa de viagem, crítica ao Império, lirismo e elementos de ficção, tudo com forte carga política e nacionalista. 
</br>
No Brasil, o Romantismo ganhou força após a Independência (1822), surgindo como um instrumento de construção da identidade nacional. A publicação de Suspiros Poéticos e Saudades (1836), de Gonçalves de Magalhães, é considerada o marco inicial do movimento no país. A literatura romântica brasileira passou a refletir elementos próprios, como a valorização da natureza tropical, das tradições populares, da religiosidade e do indígena como símbolo da nacionalidade. Com isso, formaram-se três gerações distintas que expressaram diferentes fases da literatura romântica no Brasil: </p>
        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>As principais características do Romantismo podem ser agrupadas em três gerações: </p>
            <ul>
                <ul>
    <li><strong>Primeira Geração – Nacionalista / Indianista / Religiosa (1836–1852):</strong> 
        Surgiu após a Independência, com a intenção de afirmar uma identidade literária genuinamente brasileira. 
        O indígena é valorizado como herói nacional, substituindo o cavaleiro medieval europeu. 
        Há forte presença do nacionalismo, da religiosidade e da exaltação à paisagem brasileira. 
        <br><strong>Destaques:</strong> Gonçalves de Magalhães, Gonçalves Dias e José de Alencar 
        (<em>O Guarani</em>, <em>Iracema</em>, <em>Ubirajara</em>, <em>O Sertanejo</em>). 
        Manuel Antônio de Almeida também se destaca com <em>Memórias de um Sargento de Milícias</em>, obra que rompe com o idealismo e retrata o cotidiano popular com humor e realismo.
    </li>

    <li><strong>Segunda Geração – Ultrarromântica (1853–1869):</strong> 
        Caracteriza-se pelo sentimentalismo exacerbado, introspecção, egocentrismo, idealização do amor, morbidez e atração pela morte. 
        Sofreu grande influência do poeta inglês Lord Byron, o que inspirou um tom sombrio e melancólico. 
        <br><strong>Destaques:</strong> Álvares de Azevedo (<em>Lira dos Vinte Anos</em>), Casimiro de Abreu, Fagundes Varela e Junqueira Freire.
    </li>

    <li><strong>Terceira Geração – Condoreira ou Social (1870–1880):</strong> 
        Voltada para temas sociais e políticos, especialmente o abolicionismo e o republicanismo. 
        A literatura adquire caráter engajado e idealista, influenciada pelo liberalismo e pelo humanismo. 
        <br><strong>Destaque:</strong> Castro Alves, conhecido como “o poeta dos escravos”, autor de <em>Espumas Flutuantes</em> e do poema <em>O Navio Negreiro</em> (1868).
    </li>

    <li><strong>Principais Características:</strong>
        <ul>
            <li><strong>Subjetividade e sentimentalismo:</strong> Foco no "eu", nas emoções intensas e nos conflitos internos.</li>
            <li><strong>Nacionalismo e exaltação do passado:</strong> Valorização da natureza, da paisagem e das figuras heroicas (como o índio no Brasil).</li>
            <li><strong>Idealização do amor e da mulher:</strong> Amor espiritualizado e inalcançável; a mulher como figura pura ou trágica.</li>
            <li><strong>Liberdade formal:</strong> Ruptura com a rigidez clássica, uso de versos livres e linguagem mais próxima da oralidade.</li>
            <li><strong>Fuga da realidade e escapismo:</strong> Temas como morte, sonho, natureza e tempos passados como forma de evitar o presente.</li>
            <li><strong>Religiosidade e espiritualismo:</strong> Elementos cristãos, místicos ou existenciais associados ao sofrimento e à transcendência.</li>
            <li><strong>Influência em outras artes:</strong> Na pintura e na música, cores vibrantes, temas épicos e emoção exaltada, como em obras de Delacroix e Chopin.</li>
        </ul>
    </li>
</ul>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Exemplo de obra:</h2>
            <hr />
            <p style="text-align:center;">
                 <strong>Canção do Exílio<br></strong>
Minha terra tem palmeiras, <br />
Onde canta o Sabiá; <br />
As aves, que aqui gorjeiam, <br />
Não gorjeiam como lá. <br /><br />

Nosso céu tem mais estrelas, <br />
Nossas várzeas têm mais flores, <br />
Nossos bosques têm mais vida, <br />
Nossa vida mais amores. <br /><br />

Em cismar, sozinho à noite, <br />
Mais prazer encontro eu lá; <br />
Minha terra tem palmeiras, <br />
Onde canta o Sabiá. <br /><br />

Minha terra tem primores, <br />
Que tais não encontro eu cá; <br />
Em cismar — sozinho à noite — <br />
Mais prazer encontro eu lá. <br />
Minha terra tem palmeiras, <br />
Onde canta o Sabiá. <br /><br />

Não permita Deus que eu morra, <br />
Sem que eu volte para lá; <br />
Sem que disfrute os primores <br />
Que não encontro por cá; <br />
Sem qu’inda aviste as palmeiras, <br />
Onde canta o Sabiá. <br /><br />

<small>(Gonçalves Dias, <em>Primeiros Cantos</em>, 1846)</small>
            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Romantismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'romantismo'";
            $resultObras = $conn->query($sqlObras);

            if ($resultObras && $resultObras->num_rows > 0) {
                while ($obra = $resultObras->fetch_assoc()) {
                    echo '<li class="card">';
                    echo '<img src="' . htmlspecialchars($obra['capa']) . '" alt="' . htmlspecialchars($obra['titulo']) . '" />';
                    echo '<div class="content">';
                    echo '<h3>' . htmlspecialchars($obra['titulo']) . '</h3>';
                    echo '<a href="#" class="ver-mais" data-tipo="obra" data-id="' . $obra['id'] . '">Veja Sobre</a>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<p>Nenhuma obra encontrada.</p>';
            }
            ?>
        </ul>
        <button class="nav-button right">&#10095;</button>
    </div>

    <script>
    const wrapperObras = document.currentScript.previousElementSibling.parentElement;
    const carouselObras = wrapperObras.querySelector(".carousel");
    const btnLeftObras = wrapperObras.querySelector(".nav-button.left");
    const btnRightObras = wrapperObras.querySelector(".nav-button.right");
    const firstCardObras = carouselObras.querySelector(".card");

    const stepObras = () => firstCardObras.getBoundingClientRect().width + 20; // 20 = gap

    btnLeftObras?.addEventListener("click", e => { e.preventDefault(); carouselObras.scrollBy({left: -stepObras(), behavior: 'smooth'}); });
    btnRightObras?.addEventListener("click", e => { e.preventDefault(); carouselObras.scrollBy({left: stepObras(), behavior: 'smooth'}); });
    </script>
</section>

<!-- CARROSSEL AUTORES -->
<section class="carousel-container" id="Autores">
    <div class="text">
        <h2>Principais Autores do Romantismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'romantismo'";
            $resultAutores = $conn->query($sqlAutores);

            if ($resultAutores && $resultAutores->num_rows > 0) {
                while ($autor = $resultAutores->fetch_assoc()) {
                    echo '<li class="card">';
                    echo '<img src="' . htmlspecialchars($autor['capa']) . '" alt="' . htmlspecialchars($autor['nome']) . '" />';
                    echo '<div class="content">';
                    echo '<h3>' . htmlspecialchars($autor['nome']) . '</h3>';
                    echo '<a href="#" class="ver-mais" data-tipo="autor" data-id="' . $autor['id'] . '">Veja Sobre</a>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<p>Nenhum autor encontrado.</p>';
            }
            ?>
        </ul>
        <button class="nav-button right">&#10095;</button>
    </div>

    <script>
    const wrapperAutores = document.currentScript.previousElementSibling.parentElement;
    const carouselAutores = wrapperAutores.querySelector(".carousel");
    const btnLeftAutores = wrapperAutores.querySelector(".nav-button.left");
    const btnRightAutores = wrapperAutores.querySelector(".nav-button.right");
    const firstCardAutores = carouselAutores.querySelector(".card");

    const stepAutores = () => firstCardAutores.getBoundingClientRect().width + 20; // 20 = gap

    btnLeftAutores?.addEventListener("click", e => { e.preventDefault(); carouselAutores.scrollBy({left: -stepAutores(), behavior: 'smooth'}); });
    btnRightAutores?.addEventListener("click", e => { e.preventDefault(); carouselAutores.scrollBy({left: stepAutores(), behavior: 'smooth'}); });
    </script>
</section>

<!-- Modal Obra -->
<div id="modalObra" class="modal-obra" style="display:none;">
    <div class="modal-content">
        <span class="close-modal-obra" style="cursor:pointer;">&times;</span>
        <h2 id="tituloObra">Nome da Obra</h2>
        <div class="modal-body">
            <img id="capaObra" src="../imagens/sem-imagem.svg" alt="Capa" class="modal-capa" />
            <div class="modal-texto">
                <p id="descricaoObra">Descrição da obra...</p>
                <a id="botaoDownload" href="#" target="_blank" class="btn btn-light">Baixar</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Autor -->
<div id="modalAutor" class="modal-autor" style="display:none;">
    <div class="modal-content">
        <span class="close-modal-autor" style="cursor:pointer;">&times;</span>
        <h2 id="tituloAutor">Nome do Autor</h2>
        <div class="modal-body">
            <img id="capaAutor" src="../imagens/sem-imagem.svg" alt="Foto do autor" class="modal-capa" />
            <div class="modal-texto">
                <p id="descricaoAutor">Biografia do autor...</p>
            </div>
        </div>
    </div>
</div>

 <!-- aqui: cole o bloco de PAGINAÇÃO -->
    <div class="pagination" role="navigation" aria-label="Paginação">
      <a href="../arcadismo/arcadismo.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../realismo/realismo.php" class="next" aria-label="Próxima página">></a>
    </div>

<!-- footer -->
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

<script src="main.js"></script>

<button id="backToTop" title="Voltar ao topo" aria-label="Voltar ao topo">
  <i class='bx bx-up-arrow-alt'></i>
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
</body>
</html>
