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
    <title>Naturalismo</title>
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
        <li><a href="../forum/forum.php" class="active">Fórum</a></li>
        <li><a href="../perfil/perfil.php">Minha Conta</a></li>
        <li><a href="../sobre/sobre.php">Sobre</a></li>
    </ul>
</header>

<!-- banner -->
<section class="home" id="home">
    <div class="home-text">
        <h1>Naturalismo</h1>
        <h2>(1881-1902)</h2>
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
            <img src="./img/img_naturalismo.jpeg" alt="A Primeira Missa no Brasil por Victor Meirelles" />
            <center><span>Os fabricantes de feno por Jules Bastien-Lepage (1848–1884)</span></center>
        </div>
        <div class="text">
            <h2>O que foi?</h2>
            <p> O Naturalismo foi um movimento literário surgido na segunda metade do século XIX como uma ramificação do Realismo, influenciado por teorias como o determinismo, o evolucionismo e o positivismo. Seus autores propunham uma literatura científica, voltada à análise objetiva da realidade humana, retratando o indivíduo como resultado da hereditariedade, do meio e das condições sociais. Valorizava-se a descrição minuciosa, com destaque para aspectos biológicos e instintivos do comportamento humano. Na prosa de ficção, seu principal representante foi Émile Zola, considerado o teórico do movimento com a obra Le Roman Expérimental. </p>
        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Contexto histórico:</h2>
            <hr />
            <p>
                O Naturalismo surgiu na França, na segunda metade do século XIX, como reação ao romantismo, em meio aos avanços científicos, à Segunda Revolução Industrial e à consolidação do capitalismo. Influenciado por teorias como o evolucionismo de Darwin, o determinismo de Hippolyte Taine e o positivismo de Auguste Comte, o movimento adotou uma visão científica e materialista do ser humano. A literatura naturalista passou a retratar a miséria, a violência e a degeneração, mostrando o homem como resultado da hereditariedade, do meio social e do momento histórico. 
</br>
Esse movimento refletia a crença de que o comportamento humano poderia ser estudado com os mesmos métodos das ciências experimentais. A obra "Le Roman Expérimental" (1880), de Émile Zola, é o marco teórico do Naturalismo, propondo o romance como um laboratório para estudar o ser humano como objeto biológico e social. 
</br>
No Brasil, o Naturalismo apareceu no final do século XIX, num contexto de instabilidade política e social: a crise do Império, o fim da escravidão (1888) e a Proclamação da República (1889). A literatura naturalista incorporou as teorias europeias, mas tratou de temas nacionais, como o racismo, a exploração social e a decadência das instituições. 
</br>
A estreia do movimento se deu com O Mulato (1881), de Aluísio Azevedo, seguido por O Cortiço, obra que evidencia a influência do meio sobre o comportamento humano, o determinismo e a animalização das personagens. Também se destacam O Ateneu, de Raul Pompeia, que denuncia o ambiente escolar como corruptor, e Bom-Crioulo, de Adolfo Caminha, que aborda temas como racismo, homossexualidade e marginalização. 
</p>

        </div>
    </div>

    <div class="containerr">
        <div class="text">
            <h2>Principais Características:</h2>
            <hr />
            <p>As principais características do Naturalismo podem ser agrupadas em oito vertentes: </p>
            <ul>
              <ul>
    <li><strong>Ciência como base da literatura:</strong> Influenciado pelo positivismo, evolucionismo e determinismo, o Naturalismo propõe uma literatura científica, que observa o ser humano como objeto de estudo.</li>

    <li><strong>Determinismo:</strong> Os personagens são condicionados por fatores como hereditariedade, ambiente social e época histórica. Suas ações resultam desses fatores, e não da liberdade individual.</li>

    <li><strong>Animalização do homem:</strong> O ser humano é retratado como um animal movido por instintos, principalmente o sexual, com perda da racionalidade. Isso gera a chamada <em>zoomorfização</em> dos personagens.</li>

    <li><strong>Sexualidade e pulsões:</strong> O desejo sexual aparece de forma direta, como parte da natureza humana, frequentemente ligado à degradação moral e social.</li>

    <li><strong>Cenários degradantes:</strong> As histórias se passam em ambientes como cortiços, prisões e hospitais, refletindo condições de miséria, opressão e decadência social.</li>

    <li><strong>Crítica social realista:</strong> As obras expõem problemas como racismo, desigualdade, violência e hipocrisia moral, abordando temas considerados “tabus” à época.</li>

    <li><strong>Representações preconceituosas:</strong> A mulher era vista como histérica, o negro como inferior e o homossexual como doente, refletindo os valores racistas e patriarcais do século XIX.</li>

    <li><strong>Protagonismo das classes marginalizadas:</strong> A literatura naturalista volta-se para os pobres, doentes, imigrantes e excluídos, mas sempre sob uma ótica determinada pelo meio e pela biologia.</li>
</ul>

        </div>
    </div>

    <div class="containerr clearfix">
        <div class="text">
            <h2>Exemplo de obra:</h2>
            <hr />
            <p style="text-align:center;">
                <strong>O Cortiço<br></strong>
“Daí a pouco, em volta das bicas era um zunzum crescente; uma aglomeração tumultuosa de machos e fêmeas. Uns, após outros, lavavam a cara, incomodamente, debaixo do fio de água que escorria da altura de uns cinco palmos. O chão inundava-se. As mulheres precisavam já prender as saias entre as coxas para não as molhar; via-se lhes a tostada nudez dos braços e do pescoço, que elas despiam, suspendendo o cabelo todo para o alto do casco; os homens, esses não se preocupavam em não molhar o pelo, ao contrário metiam a cabeça bem debaixo da água e esfregavam com força as ventas e as barbas, fossando e fungando contra as palmas da mão. As portas das latrinas não descansavam, era um abrir e fechar de cada instante, um entrar e sair sem tréguas. Não se demoravam lá dentro e vinham ainda amarrando as calças ou as saias; as crianças não se davam ao trabalho de lá ir, despachavam-se ali mesmo, no capinzal dos fundos, por detrás da estalagem ou no recanto das hortas.” <br /><br />

<small>(Aluísio Azevedo, <em>O Cortiço</em>, 1890)</small>

            </p>
        </div>
    </div>
</section>

<!-- CARROSSEL OBRAS -->
<section class="carousel-container" id="Obras">
    <div class="text">
        <h2>Principais Obras do Naturalismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
        <button class="nav-button left">&#10094;</button>
        <ul class="carousel">
            <?php
            $sqlObras = "SELECT id, titulo, capa, descricao, arquivo FROM obras WHERE escola_literaria = 'naturalismo'";
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
        <h2>Principais Autores do Naturalismo:</h2>
        <hr />
    </div>
    <div class="carousel-wrapper">
       
        <ul class="carousel">
            <?php
            $sqlAutores = "SELECT id, nome, capa, biografia FROM autores WHERE escola_literaria = 'naturalismo'";
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
      <a href="../realismo/realismo.php" class="prev" aria-label="Página anterior"><</a>
      <a href="../parnasianismo/parnasianismo.php" class="next" aria-label="Próxima página">></a>
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
