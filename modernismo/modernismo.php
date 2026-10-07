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
    <title>Modernismo</title>
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
        <li><a href="../obras/obras.php">ACERVO LITERÁRIO</a></li>
        <li><a href="../forum/forum.php">Fórum</a></li>
        <li><a href="../perfil/perfil.php">Minha Conta</a></li>
        <li><a href="../sobre/sobre.php">Sobre</a></li>
    </ul>
</header>

<!-- banner -->
<section class="home" id="home">
    <div class="home-text">
        <h1>Modernismo</h1>
        <h2>(1922–1945)</h2>
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
            <img src="./img/img_modernismo.jpeg" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>Abaporu por Tarsila do Amaral (1886–1973)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p>O Modernismo foi um movimento artístico e literário do século XX marcado pela ruptura com as normas acadêmicas, pela liberdade de forma e pela crítica social. No Brasil, teve como marco inicial a Semana de Arte Moderna de 1922, em um contexto de mudanças políticas e econômicas (fim da República Velha e início da Era Vargas) e sob influência das vanguardas europeias (cubismo, futurismo, dadaísmo, expressionismo e surrealismo). O movimento buscava construir uma arte crítica e autenticamente brasileira, rejeitando as regras do parnasianismo e resgatando elementos culturais e históricos do país. Dividido em três fases (1922-1930, 1930-1945 e 1945-1978). </p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
           <P> 
            No início do século XX, a Europa vivia uma atmosfera de intensos conflitos e transformações. A corrida imperialista e o fortalecimento do nacionalismo levaram à eclosão da Primeira Guerra Mundial (1914–1918). Apesar do clima de destruição, a ciência e a tecnologia evoluíam, enquanto a política era marcada pela emergência de regimes autoritários como o fascismo e o nazismo. A derrota destes após a Segunda Guerra Mundial (1939–1945) não significou uma paz ampla e duradoura: o mapa global dividiuse entre países socialistas e capitalistas, marcando o início da Guerra Fria. 
</br>
No Brasil, a República Velha entrou em colapso nas décadas de 1920 e 1930 sob pressão de forças como o tenentismo e o crescente movimento operário e comunista. A crise de 1929 prejudicou a economia e ampliou o descontentamento social, contribuindo para a chegada de Getúlio Vargas ao poder em 1930. O Estado Novo (1937–1945) intensificou a censura e perseguiu opositores e intelectuais, mas após a guerra o país viveu uma nova fase de desenvolvimento e democracia com Juscelino Kubitschek (1956–1961), antes de novamente entrar numa ditadura com o golpe de 1964. Todos esses fatos não apenas marcaram a sociedade e a política, mas serviram de matéria-prima para uma literatura crítica e engajada, que refletia e discutia as tensões e mudanças do século. 
 </p>
        </div>
        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>O modernismo pode ser caracterizado por três fases: </p>
</br>
            
<strong>Primeira Geração (1922–1930) – Fase Heroica<br></strong>
<p>
Esta fase começa com a Semana de Arte Moderna (1922) e caracteriza-se pela ruptura com as tradições artísticas anteriores, uma crítica à cultura conservadora e uma busca por uma linguagem autenticamente brasileira. Os escritores e artistas romperam com as regras do parnasianismo e adotaram uma linguagem simples, livre e crítica, com destaque para o humor, o sarcasmo e uma forte representação do Brasil e de suas culturas regionais.
</p>
<ul>
    <li><strong>Nacionalismo crítico e antirromântico</strong></li>
    <li><strong>Ironia e sarcasmo</strong></li>
    <li><strong>Linguagem coloquial e versos livres</strong></li>
    <li><strong>Influência das vanguardas europeias</strong></li>
    <li><strong>Valorização de elementos regionais e da cultura popular</strong></li>
</ul>
<p><em>Principais autores:</em> Oswald de Andrade, Mário de Andrade, Manuel Bandeira, Anita Malfatti, Tarsila do Amaral.</p>
<br />

<strong>Segunda Geração (1930–1945) – Fase de Consolidação<br></strong>
<p>
Esta fase refletiu o ambiente marcado pela crise social e política do país e pela consolidação do Estado de Vargas. Os escritores voltaram-se para uma crítica mais ampla e madura das desigualdades e dificuldades enfrentadas no país, com destaque para a prosa regionalista e uma poesia preocupada com a crítica social e existencial.
</p>
<ul>
    <li><strong>Regionalismo e denúncia social</strong></li>
    <li><strong>Linguagem simples e direta</strong></li>
    <li><strong>Influência da psicanálise e destaque para o conflito humano</strong></li>
    <li><strong>Abordagem crítica e determinista dos dramas regionais</strong></li>
</ul>
<p><em>Prosa:</em> Graciliano Ramos, Jorge Amado, Rachel de Queiroz, José Lins do Rego<br />
<em>Poesia:</em> Carlos Drummond de Andrade, Cecília Meireles, Murilo Mendes, Vinicius de Moraes</p>

<br />

<strong>Terceira Geração (1945–Atualmente) – Fase Pós-Modernista<br></strong>
<p>
A última fase do Modernismo brasileiro foi marcada por uma atmosfera de crítica e experimentação, com destaque para a poesia concreta e para uma prosa mais introspectiva e psicológica. Os escritores dessa fase não se limitavam mais ao debate do nacionalismo, mas ampliaram seu olhar para questões universais e para uma crítica mais ampla ao homem e à sociedade.
</p>
<ul>
    <li><strong>Retomada do rigor formal e estético (volta à métrica e à rima)</strong></li>
    <li><strong>Influência do simbolismo e parnasianismo</strong></li>
    <li><strong>Preocupação com a estrutura e o experimentalismo</strong></li>
    <li><strong>Prosa com destaque para o psicológico e para a crítica social</strong></li>
    <li><strong>Universalização dos temas, sem perder a relação com a realidade nacional</strong></li>
</ul>
<p><em>Prosa:</em> Clarice Lispector, Guimarães Rosa<br />
<em>Poesia:</em> João Cabral de Melo Neto, Ferreira Gullar, Haroldo e Augusto de Campos, Décio Pignatari</p>

        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Exemplo de obra:</h2>
            <hr />
            <p style="text-align:center;">
<strong>Vidas Secas<br></strong>
Na planície avermelhada os juazeiros alargavam duas manchas verdes. <br />
Os infelizes tinham caminhado o dia inteiro, estavam cansados e famintos. <br />
Ordinariamente andavam pouco, mas como haviam repousado bastante na areia do rio seco, <br />
a viagem progredira bem três léguas. <br />
Fazia horas que procuravam uma sombra. <br />
A folhagem dos juazeiros apareceu longe, através dos galhos pelados da catinga rala. <br /><br />

<small>(Graciliano Ramos, <em>Vidas Secas</em>, 1938)</small>

            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Modernismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'modernismo'";
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
        <h2>Principais Autores do Modernismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'modernismo'";
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
      <a href="../pre-modernismo/pre-modernismo.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../pos-modernismo/pos-modernismo.php" class="next" aria-label="Próxima página">></a>
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
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const response = await fetch("../enviar_email.php", { method: "POST", body: formData });
        const texto = (await response.text()).trim();
        console.log("Resposta do PHP:", texto); // <-- aqui você vê no console o retorno

        if (texto === "success") {
            alert("✅ Mensagem enviada com sucesso!");
            this.reset();
        } else {
            alert("❌ Ocorreu um erro ao enviar. Retorno: " + texto);
        }
    } catch (err) {
        alert("❌ Erro de conexão. Tente novamente.");
        console.error(err);
    }
});

</script>
</body>
</html>
