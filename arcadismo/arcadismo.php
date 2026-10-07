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
    <title>Arcadismo</title>
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
        <h1>Arcadismo</h1>
        <h2>(1768-1836)</h2>
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
            <img src="./img/img_arcadismo.jpg" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>O Balanço por Jean-Honoré Fragonard (1732–1806)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p> O Arcadismo, também conhecido como Neoclassicismo ou Setecentismo, foi um movimento literário que emergiu na Europa durante o século XVIII, influenciado pelos ideais iluministas. Caracterizado pela valorização da razão, da simplicidade e da natureza, buscava retomar os princípios estéticos da Antiguidade Clássica, em oposição aos excessos do Barroco. Esse movimento foi marcado pela retomada das temáticas greco-latinas e pela ênfase nas descrições bucólicas da natureza.  </p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
            <p>Esse movimento surgiu durante o "Século das Luzes", um período de ascensão do Iluminismo, quando as ideias iluministas, que defendiam a razão, a ciência e o progresso, começaram a moldar as artes e a literatura, tanto na Europa quanto no Brasil. 

Na Europa, o Arcadismo foi influenciado pela Revolução Francesa, que impulsionou a ascensão da burguesia, e pela Revolução Industrial, que promoveu o capitalismo e a mecanização. Esses eventos transformaram o cenário social e cultural, tornando o Arcadismo uma resposta à busca por uma vida mais equilibrada e racional, com base nos ideais da Antiguidade Clássica. 

<br/> No Brasil, o Arcadismo surgiu em um contexto de forte colonização e exploração do ouro em Minas Gerais, que se tornou o centro econômico do país. Ao mesmo tempo, o movimento da Inconfidência Mineira, que buscava a independência do Brasil, também influenciou a literatura árcade. Muitos dos poetas brasileiros estudaram em Coimbra, Portugal, onde foram impactados pelas ideias iluministas e, ao retornar, trouxeram essas influências para o Brasil, contribuindo para a literatura e para os primeiros movimentos de independência, como a Inconfidência Mineira. </p>
        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>As principais características do Arcadismo podem ser agrupadas em vertentes: </p>
            <ul>
                <ul>
    <li><strong>Racionalismo e Simplicidade:</strong> Valorização da razão e da linguagem clara, em oposição à complexidade e ao rebuscamento do Barroco.</li>

    <li><strong>Bucolismo e Idealização da Natureza:</strong> Exaltação da vida no campo, vista como símbolo de pureza e tranquilidade.</li>

    <li><strong>Uso de Pseudônimos Pastorais:</strong> Os poetas adotavam nomes fictícios inspirados em pastores da mitologia greco-romana, como <em>Dirceu</em> (Tomás Antônio Gonzaga) e <em>Glauceste Satúrnio</em> (Cláudio Manuel da Costa).</li>

    <li><strong>Imitação dos Clássicos:</strong> Inspiração nos modelos da Antiguidade, especialmente nos poetas latinos como Horácio e Virgílio.</li>

    <li><strong>Temas Nacionalistas:</strong> No Brasil, o Arcadismo incorporou elementos da realidade local, como a paisagem tropical e a figura do indígena, iniciando uma reflexão sobre a identidade nacional.</li>

    <li><strong>Preceitos Latinos:</strong> Adoção de máximas clássicas como:
        <ul>
            <li><em>Fugere Urbem</em> (fugir do urbano)</li>
            <li><em>Locus Amoenus</em> (lugar ameno)</li>
            <li><em>Aurea Mediocritas</em> (equilíbrio das riquezas)</li>
            <li><em>Inutilia Truncat</em> (rejeição ao superficial)</li>
            <li><em>Carpe Diem</em> (aproveitar o dia)</li>
        </ul>
    </li>

    <li><strong>Produções Literárias:</strong> Dois tipos principais marcaram o período:
        <ul>
            <li><strong>Lírica:</strong> Poemas feitos com características simples, sem muito enfeite, exagero ou emoções dramáticas.</li>
            <li><strong>Épica:</strong> Baseada no racionalismo e na valorização dos grandes feitos, destacando o heroísmo do índio em detrimento ao homem branco.</li>
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
                 <strong>Lira I<br></strong>
Eu, Marília, não sou algum vaqueiro, <br />
Que viva de guardar alheio gado; <br />
De tosco trato, d’expressões grosseiro, <br />
Dos frios gelos, e dos sóis queimado. <br /><br />

Tenho próprio casal, e nele assisto; <br />
Dá-me vinho, legume, fruta, azeite; <br />
Das brancas ovelhinhas tiro o leite, <br />
E mais as finas lãs, de que me visto. <br /><br />

Graças, Marília bela, <br />
Graças à minha Estrela! <br /><br />

Eu vi o meu semblante numa fonte, <br />
Dos anos inda não está cortado: <br />
Os pastores, que habitam este monte, <br />
Com tal destreza toco a sanfoninha, <br />
Que inveja até me tem o próprio Alceste: <br />
Ao som dela concerto a voz celeste; <br />
Nem canto letra, que não seja minha, <br />
Graças, Marília bela, <br />
Graças à minha Estrela! <br /><br />

[...] <br /><br />

<small>(Tomás Antônio Gonzaga, Marília de Dirceu, 1792)</small>

            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Arcadismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'arcadismo'";
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
        <h2>Principais Autores do Arcadismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapperr">
        
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'Arcadismo'";
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
      <a href="../barroco/barroco.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../romantismo/romantismo.php" class="next" aria-label="Próxima página">></a>
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
