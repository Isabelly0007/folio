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
    <title>Realismo</title>
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
        <h1>Realismo</h1>
        <h2>(1881-1893)</h2>
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
            <img src="./img/img_realismo.jpg" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>O Violeiro por Almeida Júnior (1850–1899)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p> O Realismo foi um movimento artístico e literário que surgiu na Europa na segunda metade do século XIX, em oposição ao idealismo e sentimentalismo do Romantismo. Valorizava a representação objetiva da realidade, com foco em temas sociais, políticos e econômicos. Na literatura, utilizava linguagem clara, análise psicológica e crítica à burguesia. A obra que marca o início do movimento é Madame Bovary (1856), de Gustave Flaubert. Nas artes plásticas, destacou a vida da classe operária e dos camponeses, refletindo as desigualdades sociais após a Revolução Industrial. </p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
            <p><strong>Europa</strong></p>
<p>
O Realismo surgiu na Europa na segunda metade do século XIX, impulsionado pelas transformações da Segunda Revolução Industrial e pelas revoluções de 1848. 
A urbanização, as más condições de trabalho e o crescimento das desigualdades sociais levaram os escritores a retratar a realidade de forma crítica.
</p>
<p>
O movimento foi influenciado por correntes científicas e filosóficas como o <strong>Positivismo</strong> (Auguste Comte), o <strong>Evolucionismo</strong> (Charles Darwin) e o <strong>Marxismo</strong> (Karl Marx e Engels), que valorizavam a observação, a razão e a análise social. 
Essas ideias também geraram teorias como o <em>determinismo</em> e o <em>darwinismo social</em>, que tentavam explicar o comportamento humano com base em fatores biológicos e sociais.
</p>

<p><strong>Brasil</strong></p>
<p>
No Brasil, o Realismo surgiu em um momento de grandes mudanças: fim do Segundo Reinado, abolição da escravidão (1888) e Proclamação da República (1889). 
Esse cenário estimulou uma literatura crítica às estruturas sociais e políticas.
</p>
<p>
A obra <em>Memórias Póstumas de Brás Cubas</em> (1881), de Machado de Assis, marcou o início do Realismo brasileiro. 
O período também viu o fortalecimento da crítica literária, do jornalismo e da reflexão filosófica e histórica. 
A fundação da <strong>Academia Brasileira de Letras</strong> (1897) consolidou o prestígio da literatura nacional.
</p>
<p>
O movimento perdeu força no início do século XX, com o surgimento do <strong>Pré-Modernismo</strong>, mas deixou grande influência na literatura brasileira.
</p>

        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>As principais características do Realismo podem ser agrupadas em dez vertentes: </p>
            <ul>
               <ul>
    <li><strong>Objetividade e linguagem direta:</strong> Uso de linguagem clara, precisa e sem exageros. A intenção era representar a realidade como ela é, sem idealizações ou fantasias.</li>

    <li><strong>Crítica à sociedade burguesa:</strong> Exposição das contradições e da hipocrisia da burguesia, abordando temas como corrupção, moral falsa, casamento por interesse e adultério, em tom de denúncia social.</li>

    <li><strong>Análise psicológica:</strong> Personagens retratados com profundidade, revelando motivações, contradições internas e conflitos morais.</li>

    <li><strong>Narrador impessoal:</strong> Preferência por narradores em terceira pessoa, com postura neutra e analítica, distante da emoção e da subjetividade romântica.</li>

    <li><strong>Temas cotidianos e realistas:</strong> Foco no dia a dia, em situações comuns e ambientes urbanos, buscando <em>verossimilhança</em> (semelhança com a realidade).</li>

    <li><strong>Influência científica e filosófica:</strong> Correntes como o Positivismo, o Darwinismo e o Determinismo influenciaram a literatura, propondo uma abordagem racional, empírica e científica da realidade humana e social.</li>

    <li><strong>Contenção emocional:</strong> O sentimentalismo exagerado do Romantismo foi abandonado; o Realismo valorizava a razão, tratando as emoções com moderação e crítica.</li>

    <li><strong>Representações mais realistas de homens e mulheres:</strong> Mulheres deixaram de ser idealizadas e passaram a ser retratadas com complexidade, inclusive como figuras manipuladoras. Homens não eram mais heróis românticos, mas personagens falhos e muitas vezes ridículos.</li>
</ul>

        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Exemplo de obra:</h2>
            <hr />
            <p style="text-align:center;">
                 <strong>Memórias Póstumas de Brás Cubas<br></strong>
“Vim... Mas não; não alonguemos este capítulo. Às vezes, esqueço-me a escrever, e a pena vai comendo papel, 
com grave prejuízo meu, que sou autor. Capítulos compridos quadram melhor a leitores pesadões; 
e nós não somos um público in-folio, mas in-12, pouco texto, larga margem, tipo elegante, corte dourado e vinhetas... 
Não, não alonguemos o capítulo.” <br /><br />

<small>(Machado de Assis, <em>Memórias Póstumas de Brás Cubas</em>, 1881)</small>

            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Realismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'realismo'";
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
        <h2>Principais Autores do realismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'realismo'";
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
      <a href="../romantismo/romantismo.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../naturalismo/naturalismo.php" class="next" aria-label="Próxima página">></a>
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
