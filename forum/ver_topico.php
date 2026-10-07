<?php
require_once __DIR__ . '/../conexao.php';

exigir_login();
$usuario_id = $_SESSION['usuario_id'];

// Pega ID do tópico
$topico_id = intval($_GET['id'] ?? 0);
if ($topico_id <= 0) {
    header("location: forum.php");
    exit();
}

// Busca informações do tópico
$sql_topico = "SELECT t.*, u.username 
               FROM topicos t 
               JOIN usuarios u ON t.usuario_id = u.id
               WHERE t.id = ?";
$stmt = $conn->prepare($sql_topico);
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$result_topico = $stmt->get_result();
$topico = $result_topico->fetch_assoc();
$stmt->close();

if (!$topico) {
    echo "Tópico não encontrado.";
    exit();
}

// Busca respostas
$sql_respostas = "SELECT r.*, u.username 
                  FROM respostas r 
                  JOIN usuarios u ON r.usuario_id = u.id 
                  WHERE r.topico_id = ? 
                  ORDER BY r.data_criacao ASC";
$stmt = $conn->prepare($sql_respostas);
$stmt->bind_param("i", $topico_id);
$stmt->execute();
$res_respostas = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($topico['titulo']) ?> - Fórum Literário</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="topico.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
<link rel="icon" href="../escolas/img/logo.png" type="image/png">
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
<body>

<!-- NAVBAR -->
<header>
    <a class="logo"><img src="../escolas/img/logo.png" alt="Logo do site" />Fólio</a>
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

<!-- TÓPICO -->
<div class="topico">
<strong><a href="../publico/perfil_publico.php?id=<?= $topico['usuario_id'] ?>">@<?= htmlspecialchars($topico['username']) ?></a></strong> - <span><?= htmlspecialchars($topico['titulo']) ?></span><br>
<p><?= nl2br(htmlspecialchars($topico['conteudo'])) ?></p>
<small>Obra: <?= htmlspecialchars($topico['obra_relacionada'] ?: 'Não informada') ?> | Criado em: <?= $topico['data_criacao'] ?></small><br>

<?php
// --- ESTRELAS E CONTADOR ---
$topico_id = $topico['id'];

// Verifica se o usuário já votou neste tópico
$check_vote = $conn->prepare("SELECT estrelas FROM votos_topicos WHERE usuario_id=? AND topico_id=?");
$check_vote->bind_param("ii", $usuario_id, $topico_id);
$check_vote->execute();
$res_check = $check_vote->get_result();
$usuario_votou = $res_check->num_rows > 0;
$usuario_estrelas = $usuario_votou ? $res_check->fetch_assoc()['estrelas'] : 0;

// Pega quantidade de votos real do tópico
$res_votos = $conn->query("SELECT COUNT(*) AS votos FROM votos_topicos WHERE topico_id=$topico_id");
$votos_data = $res_votos->fetch_assoc();
$votos = intval($votos_data['votos']);

// Container de estrelas
echo "<div class='estrelas' data-id='".$topico_id."' data-ja-votou='".($usuario_votou ? 1 : 0)."'>";
for ($i = 1; $i <= 5; $i++) {
    $checked = $i <= ($usuario_votou ? $usuario_estrelas : intval($topico['estrelas'])) ? 'checked' : '';
    echo "<span class='estrela $checked' data-value='$i'>★</span>";
}
echo " <span class='contador-votos' data-votos='$votos'>($votos votos)</span>";
echo "</div>";
?>
</div>

<section class="pdt">
    <h3>Responder</h3>
<form class="tpc" action="responder.php" method="post">
    <input type="hidden" name="topico_id" value="<?= $topico['id'] ?>">
    <textarea name="conteudo" placeholder="Escreva sua resposta..." required></textarea><br>
    <button type="submit">Postar Resposta</button>

<h3>Respostas</h3>
<?php if ($res_respostas->num_rows > 0): ?>
    <?php while ($r = $res_respostas->fetch_assoc()): ?>
        <div class="topico resposta">
            <strong>
                <a href="../publico/perfil_publico.php?id=<?= $r['usuario_id'] ?>">@<?= htmlspecialchars($r['username']) ?></a>
            </strong>
            <small>respondeu em: <?= $r['data_criacao'] ?></small>
            <p><?= nl2br(htmlspecialchars($r['conteudo'])) ?></p>
            
            <?php if ($r['usuario_id'] == $usuario_id): ?>
                <a href="excluir_resposta.php?id=<?= $r['id'] ?>" class="excluir-resposta"
                   onclick="return confirm('Deseja realmente excluir esta resposta?')">Excluir</a>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Nenhuma resposta ainda.</p>
<?php endif; ?>

</form>
</section>

<!-- FOOTER OMITIDO PARA BREVIDADE, MANTENHA SEU CÓDIGO DE FOOTER AQUI -->

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

// Sistema de estrelas via AJAX
document.querySelectorAll('.estrela').forEach(e => {
    e.addEventListener('click', () => {
        const valor = e.getAttribute('data-value');
        const container = e.parentElement;
        const id = container.getAttribute('data-id');
        const jaVotou = container.dataset.jaVotou === "1";

        if (jaVotou) {
            alert("⚠️ Você já votou neste tópico.");
            return;
        }

        container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = 'none');

        fetch('forum.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `topico_id=${encodeURIComponent(id)}&estrelas=${encodeURIComponent(valor)}`
        })
        .then(res => res.text())
        .then(text => {
            if(text.trim() === "ok") {
                container.querySelectorAll('.estrela').forEach(star => {
                    star.classList.toggle('checked', parseInt(star.getAttribute('data-value')) <= parseInt(valor));
                });

                let votosSpan = container.querySelector('.contador-votos');
                if (votosSpan) {
                    let votos = parseInt(votosSpan.dataset.votos || '0');
                    votos = votos + 1;
                    votosSpan.dataset.votos = votos;
                    votosSpan.textContent = `(${votos} votos)`;
                }

                container.dataset.jaVotou = "1";
                alert("⭐ Voto registrado com sucesso!");
            } else if(text.trim() === "ja_votou") {
                alert("⚠️ Você já votou neste tópico.");
            }
            container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
        })
        .catch(err => {
            console.error(err);
            alert('❌ Erro ao registrar voto. Tente novamente.');
            container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
        });
    });
});
</script>

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

<script src="../js/contato.js"></script>

</body>
</html>
