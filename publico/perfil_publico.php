<?php
require_once __DIR__ . '/../conexao.php';

// ID do usuário vindo da URL
$usuario_id = intval($_GET['id'] ?? 0);

// Se não tiver ID válido
if ($usuario_id <= 0) {
    die("Perfil inválido.");
}

// Busca dados do usuário
$sql_usuario = "SELECT nome, username, bio, foto FROM usuarios WHERE id = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();

if ($result_usuario->num_rows === 0) {
    die("Usuário não encontrado.");
}
$userData = $result_usuario->fetch_assoc();

// Busca tópicos
$sql_topicos = "SELECT id, titulo, conteudo, data_criacao FROM topicos WHERE usuario_id = ? ORDER BY data_criacao DESC";
$stmt_topicos = $conn->prepare($sql_topicos);
$stmt_topicos->bind_param("i", $usuario_id);
$stmt_topicos->execute();
$result_topicos = $stmt_topicos->get_result();

// Busca respostas
$sql_respostas = "
    SELECT r.conteudo, r.data_criacao, t.titulo AS titulo_topico
    FROM respostas r
    JOIN topicos t ON r.topico_id = t.id
    WHERE r.usuario_id = ?
    ORDER BY r.data_criacao DESC
";
$stmt_respostas = $conn->prepare($sql_respostas);
$stmt_respostas->bind_param("i", $usuario_id);
$stmt_respostas->execute();
$result_respostas = $stmt_respostas->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Perfil de <?= htmlspecialchars($userData['username']) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
<link rel="icon" href="../escolas/img/logo.png" type="image/png">
<link rel="stylesheet" href="style.css" />
<style>
.estrela { font-size: 20px; cursor: pointer; color: #ccc; margin-right: 2px; }
.estrela.checked { color: gold; }
.topico, .resposta { border: 1px solid #ddd; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
.topico strong, .resposta strong { color: #333; }
body {
  background-color: #fff1f1;
}
</style>
  <link rel="stylesheet" href="../css/tema.css" />
  <script src="../js/tema.js" defer></script>
</head>
<!-- NAVBAR -->
<header>
    <a class="logo"><img src="../escolas/img/logo.png" alt="Logo do site" />Fólio</a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <li><a href="../carta/carta.html">Home</a></li>
        <li><a href="../escolas/escolas.html">Escolas Literárias</a></li>
        <li><a href="../obras/obras.php">ACERVO LITERÁRIO
        </a></li>
        <li><a href="../forum/forum.php" class="active">Fórum</a></li>
        <li><a href="../perfil/perfil.php">Minha Conta</a></li>
        <li><a href="../sobre/sobre.php">Sobre</a></li>
    </ul>
</header>

<body>

<section class="pf">
<center><div class="card-foto">
<div class="perfil-box">
    <img src="<?= htmlspecialchars(foto_perfil($userData['foto'])) ?>" class="foto-perfil">
    <h3 class="nome-perfil">@<?= htmlspecialchars($userData['username']) ?></h3>
<?php if (!empty($userData['bio'])): ?><p class="fst-italic">"<?= htmlspecialchars($userData['bio']) ?>"</p><?php endif; ?>
</div>
</center>

    </div> </center>

   <h4 class="ttl">Tópicos Criados</h4>
<div class="lista-topicos">
<?php if ($result_topicos->num_rows > 0): ?>
    <?php while ($t = $result_topicos->fetch_assoc()): ?>
        <?php
        $topico_id = $t['id'];

        // Pega estrelas médias e votos
        $res_media = $conn->query("SELECT AVG(estrelas) AS media, COUNT(*) AS votos FROM votos_topicos WHERE topico_id=$topico_id");
        $dados = $res_media->fetch_assoc();
        $media = round($dados['media'] ?? 0, 1);
        $votos = intval($dados['votos'] ?? 0);
        ?>
        <div class="topico" style="border:1px solid #ddd; padding:10px; margin-bottom:15px; border-radius:5px;">
            <strong><a href="../publico/perfil_publico.php?id=<?= $usuario_id ?>">@<?= htmlspecialchars($userData['username']) ?></a></strong>
            <span> - <?= htmlspecialchars($t['titulo']) ?></span><br>
            <p><?= nl2br(htmlspecialchars($t['conteudo'])) ?></p>
            <small>Criado em <?= date('d/m/Y H:i', strtotime($t['data_criacao'])) ?></small><br>

            <!-- ESTRELAS -->
            <div class="estrelas" data-id="<?= $topico_id ?>">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="estrela <?= $i <= $media ? 'checked' : '' ?>">★</span>
                <?php endfor; ?>
                <span class="contador-votos">(<?= $votos ?> votos)</span>
            </div>

            <a href="../forum/ver_topico.php?id=<?= $t['id'] ?>"class="tpca">Ver tópico completo</a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p class="text-muted">Este usuário ainda não criou tópicos.</p>
<?php endif; ?>
</div>

<!-- Estilo igual ao fórum -->
<style>
    .estrelas { display: inline-block; margin-top:5px; }
    .estrela { font-size: 20px; color: #ccc; margin-right: 2px; }
    .estrela.checked { color: gold; }
</style>

</section>
<br><br>
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
