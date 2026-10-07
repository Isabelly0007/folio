<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sobre Nós - Fólio</title>
<link rel="icon" href="../escolas/img/logo.png" type="image/png">
  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- BOXICONS (fundamental para o menu mobile) -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


  <!-- CSS DA PÁGINA -->
  <link rel="stylesheet" href="sobre.css">
  <link rel="stylesheet" href="../css/tema.css" />
  <script src="../js/tema.js" defer></script>
</head>
<body>

<header>
    <a class="logo" href="#">
        <img src="../escolas/img/logo.png" alt="Logo do site">
        Fólio
    </a>

    <div class="bx bx-menu" id="menu-icon"></div>

    <ul class="navbar">
        <li><a href="../carta/carta.html">Home</a></li>
        <li><a href="../escolas/escolas.html">Escolas Literárias</a></li>
        <li><a href="../obras/obras.php">acervo literário</a></li>
        <li><a href="../forum/forum.php">Fórum</a></li>
        <li><a href="../perfil/perfil.php">Minha Conta</a></li>
        <li><a href="../sobre/sobre.php" class="active">Sobre</a></li>
    </ul>
</header>
<br>
<BR>

<!-- ONDAS -->
<div class="ondas-svg">
  <svg viewBox="0 0 1440 120" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0,40 C480,120 960,0 1440,40 L1440,120 L0,120 Z" fill="#fcd6ab"></path>
    <path d="M0,60 C480,-30 960,150 1440,60 L1440,120 L0,120 Z" fill="#d7744c"></path>
    <path d="M0,90 C480,68 960,180 1440,90 L1440,120 L0,120 Z" fill="#4d0101"></path>
  </svg>
</div>


<!-- SOBRE NÓS -->
<section class="sobre-nos text-center text-white">
  <h2>SOBRE NÓS</h2>
  <div class="mt-4 px-3 px-md-5">
    <h4>Qual o nosso propósito?</h4>
    <p class="textinho">
      O Fólio foi criado com o objetivo de tornar o estudo da literatura brasileira mais acessível,
      interativo e interessante para estudantes e apaixonados por leitura. A proposta é reunir
      informações completas sobre autores, movimentos literários e obras, apresentando tudo de forma
      organizada e visualmente atrativa.
      Além de auxiliar quem está estudando para vestibulares e ENEM, o Fólio incentiva o hábito da
      leitura e a compreensão do contexto histórico de cada época. O site também conta com recursos
      interativos como cadastro de usuários, fórum e sistema de pesquisa.
    </p>
  </div>
</section>


<!-- EQUIPE -->
<section class="equipe text-center py-5">
  <h3 class="mb-5">Quem está por trás do projeto?</h3>

  

  <div class="cards-grid">
    <div class="card">
      <img src="isabelly.jpeg" alt="Imagem 1" />
         <p class="card-desc">Isabelly Pereira de França</p>
    </div>

    <div class="card">
      <img src="sabrina.jpeg" alt="Imagem 2" />
         <p class="card-desc">Sabrina Costa</p>
    </div>

    <div class="card">
      <img src="thabata.png" alt="Imagem 3" />
         <p class="card-desc">Thabata Oliveira</p>
    </div>

    <div class="card">
      <img src="thais.jpeg" alt="Imagem 4" />
      <p class="card-desc">Thais Mamani Rodriguez</p>
    </div>
  </div>
     
</section>

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


<!-- SCRIPT MENU -->
<script>
let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");

menu.onclick = () => {
  menu.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};

window.onscroll = () => {
  menu.classList.remove("bx-x");
  navbar.classList.remove("active");
};
</script>

<script src="../js/contato.js"></script>
</body>
</html>
