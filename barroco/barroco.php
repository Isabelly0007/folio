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
    <title>Barroco</title>
<link rel="icon" href="../escolas/img/logo.png" type="image/png">
    <link rel="stylesheet" href="styl.css" />
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
        <h1>Barroco</h1>
        <h2>(1601-1768)</h2>
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
            <img src="./img/img_barroco.jpg" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>Pintura na Igreja de São Francisco de Assis, em Ouro Preto (MG) por Manuel da Costa Ataíde (1762-1830)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p>O Barroco foi um movimento artístico e cultural que floresceu entre o final do século XVI e o início do século XVIII, inicialmente na Itália, e se espalhou por diversos países europeus e suas colônias. Marcado pela forte influência religiosa, devido ao contexto da Reforma Protestante e da Contrarreforma, o Barroco expressou contradições e contrastes intensos, buscando impressionar e emocionar o observador. Sua estética incorporou exagero, paradoxo, antítese, religiosidade e elementos da cultura clássica. No Brasil, destacam-se, no campo literário, os escritores Gregório de Matos e Padre Antônio Vieira.</p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
            <p>O Barroco surgiu no final do Renascimento, entre os séculos XVI e XVIII, em um contexto de intensas transformações sociais, políticas e religiosas. A Reforma Protestante, iniciada por Martinho Lutero em 1517, desafiou a autoridade da Igreja Católica, gerando uma divisão religiosa na Europa. Lutero criticou práticas como a venda de indulgências e defendeu que a salvação se dava pela fé e não por rituais ou pagamentos. Isso provocou uma onda de adesão ao protestantismo, especialmente entre a burguesia, que se afastava da Igreja Católica.
Em resposta, a Igreja Católica iniciou a Contrarreforma, com o objetivo de reafirmar sua autoridade e combater a propagação do protestantismo. O Concílio de Trento (1545-1563) foi um dos marcos dessa reação, estabelecendo medidas como a criação do Índice de livros proibidos, a fundação da Companhia de Jesus e a intensificação da censura e perseguição através da Santa Inquisição.
Esse cenário de polarização religiosa e busca por reafirmação espiritual moldou as expressões artísticas do Barroco, utilizando elementos emocionais para transmitir o poder da fé e a fragilidade humana. Ao mesmo tempo refletia sobre o desejo de ostentação e prazer sensorial, especialmente entre as classes favorecidas pela riqueza gerada pela colonização e pelo comércio.
</p>
        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>As principais características do Barroco podem ser agrupadas em oito vertentes:</p>
            <ul>
                <li><strong>Dualismo e Contradições:</strong> O Barroco é marcado por uma profunda tensão entre opostos: corpo e alma, fé e razão, céu e terra, espiritual e material. Reflete o conflito entre a visão teocêntrica (Deus como centro do universo) e a antropocêntrica (homem como centro), resultado do choque entre os valores medievais e os ideais renascentistas. Essa oposição é uma das maiores fontes temáticas do movimento.</li>
                <li><strong>Religiosidade Intensa:</strong> A influência da Igreja Católica é central, especialmente por conta da Contrarreforma. As obras abordam temas como pecado, salvação, misticismo e culpa cristã, muitas vezes usando a arte como forma de instrução e persuasão religiosa.</li>
                <li><strong>Dramaticidade e Expressividade:</strong> As manifestações artísticas e literárias buscam comover e envolver emocionalmente o público. Há uma teatralidade evidente, com representações intensas e emocionais que refletem o espírito turbulento da época.</li>
                <li><strong>Estilo Rebuscado e Ornamentado:</strong> A linguagem barroca é sofisticada, marcada por figuras de linguagem como metáforas, antíteses, hipérboles e inversões sintáticas. Na poesia, há predileção pelo soneto, uso da medida nova e construções frasais complexas e elaboradas.</li>
                <li><strong>Exagero, Ostentação e Exuberância:</strong> A estética barroca valoriza o excesso e a riqueza de detalhes. Na arquitetura, pintura e escultura, é comum o uso de ornamentos exuberantes e efeitos visuais que visam impressionar pela grandiosidade.</li>
                <li><strong>Contrastes Visuais (Chiaroscuro):</strong> Na pintura, destaca-se o uso dramático de luz e sombra, técnica chamada de chiaroscuro, que intensifica a profundidade emocional das cenas e reforça o simbolismo dos contrastes.</li>
                <li><strong>Cultismo (ou Gongorismo):</strong> Estilo literário voltado à forma, com linguagem rebuscada, jogos de palavras e metáforas elaboradas. Influenciado pelo poeta espanhol Luis de Góngora, é marcado pelo preciosismo estético e pela sofisticação verbal.</li>
                <li><strong>Conceptismo:</strong> Voltado ao conteúdo, o conceptismo é caracterizado pelo uso de argumentos racionais, lógica e reflexão profunda. Muito presente na prosa, especialmente nos sermões de Padre Antônio Vieira, valoriza a articulação de ideias e conceitos complexos.</li>
            </ul>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Exemplo de obra:</h2>
            <hr />
            <p style="text-align:center;">
                <strong>Inconstância dos bens do mundo<br></strong>
                Nasce o Sol, e não dura mais que um dia, <br />
                Depois da Luz se segue a noite escura,<br />
                Depois da Luz se segue a noite escura,<br />
                Em contínuas tristezas a alegria.<br />
                Porém, se acaba o Sol, por que nascia?<br />
                Se é tão formosa a Luz, por que não dura?<br />
                Como a beleza assim se transfigura?<br />
                Como o gosto da pena assim se fia?<br />
                Mas no Sol, e na Luz falte a firmeza,<br />
                Na formosura não se dê constância,<br />
                E na alegria sinta-se tristeza.<br />
                Começa o mundo enfim pela ignorância,<br />
                E tem qualquer dos bens por natureza<br />
                A firmeza somente na inconstância.<br />
                <small>(Gregório de Matos, Inconstância dos bens do mundo, 1695)</small>
            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Barroco:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
      
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'Barroco'";
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
        <h2>Principais Autores do Barroco:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'Barroco'";
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
      <a href="../quinhentismo/quinhentismo.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../arcadismo/arcadismo.php" class="next" aria-label="Próxima página">></a>
    </div>

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
