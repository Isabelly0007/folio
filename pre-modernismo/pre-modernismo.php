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
    <title>Pré-modernismo</title>
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
        <h1>Pré-modernismo</h1>
        <h2>(1902–1922)</h2>
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
            <img src="./img/img_pre-modernismo.jpg" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>O Derrubador Brasileiro por Almeida Júnior (1850–1899)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p>Pré-Modernismo foi um período de transição na literatura brasileira entre o simbolismo e o modernismo. Não constitui uma escola literária, mas sim uma fase marcada por diversidade estética, reunindo elementos do realismo, naturalismo, parnasianismo e simbolismo, além de traços neo-realistas, neo-parnasianos e neo-simbolistas. Caracteriza-se pelo nacionalismo crítico e por forte crítica social, econômica e política, influenciada por eventos como a Proclamação da República, a Guerra de Canudos e o surgimento das favelas. Na Europa, o momento equivalente foi marcado por tensões políticas e movimentos de vanguarda.</p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
           <P> A virada do século XIX para o XX no Brasil foi marcada pela transição da Monarquia para a República, dominada pela oligarquia do café (São Paulo e Minas) e influenciada pela ascensão da indústria e do capital estrangeiro. A abolição não garantiu direitos aos exescravos, ampliando as desigualdades e formando uma massa de marginalizados. Os primeiros anos republicanos — a República da Espada — foram marcados por autoritarismo e revoltas como Canudos, a Revolta da Armada e a Revolução Federalista. 
</br>
A urbanização no Rio de Janeiro expulsou pobres para as periferias e deu origem às favelas. No Nordeste, a seca e a miséria levaram à formação do arraial de Canudos sob liderança de Antônio Conselheiro. Nesse cenário de tensões e contrastes, nasceu o prémodernismo, uma literatura crítica e realista, sem idealizações, com linguagem simples e destaque para questões sociais e regionais. 
</br>
Paralelamente, a Europa vivia tensões imperialistas e o surgimento das vanguardas artísticas (expressionismo, cubismo, futurismo, dadaísmo e surrealismo), que influenciariam a ruptura modernista no Brasil com a Semana de 1922. 
 </p>
        </div>
        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>As principais características do pré-modernismo podem ser agrupadas em quatro vertentes: </p>
            <ul>
    <li><strong>Nacionalismo crítico e social:</strong> Destaque para a denúncia das desigualdades e representação do Brasil marginalizado, em oposição às visões idealizadas e às influências europeias.</li>

    <li><strong>Renovação da linguagem:</strong> Uso de linguagem simples e coloquial, ampliada por regionalismos, gírias e neologismos, e aproximação entre texto literário e jornalístico.</li>

    <li><strong>Variedade temática e estética:</strong> Incorporação de elementos do realismo, naturalismo e simbolismo, abordando questões políticas, econômicas e sociais.</li>

    <li><strong>Ruptura com o academicismo e o parnasianismo:</strong> Destaque para uma representação crítica e direta da realidade, com foco nas personagens marginalizadas (sertanejo, caipira, mulato).</li>
</ul>

        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Exemplo de obra:</h2>
            <hr />
            <p style="text-align:center;">
<strong>Os Sertões<br></strong>
"O sertanejo é, antes de tudo, um forte. Não tem o raquitismo exaustivo dos mestiços neurastênicos do litoral. <br />

A sua aparência, entretanto, ao primeiro lance de vista, revela o contrário. Falta-lhe a plástica impecável, o desempenho, a estrutura corretíssima das organizações atléticas. <br />

É desgracioso, desengonçado, torto. Hércules-Quasímodo, reflete no aspecto a fealdade típica dos fracos. O andar sem firmeza, sem aprumo, quase gigante e sinuoso, aparenta a translação de membros desarticulados." <br /><br />

<small>(Euclides da Cunha, <em>Os Sertões</em>, 1902)</small>

            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Pré-modernismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'pré-modernismo'";
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
        <h2>Principais Autores do Pré-Modernismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'pré-modernismo'";
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
      <a href="../simbolismo/simbolismo.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../modernismo/modernismo.php" class="next" aria-label="Próxima página">></a>
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
