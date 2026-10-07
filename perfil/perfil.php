<?php
require_once __DIR__ . '/../conexao.php';

exigir_login();

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'] ?? 'Usuário';

// BUSCA DADOS DO USUÁRIO
$sql_usuario = "SELECT nome, username, email, bio, foto FROM usuarios WHERE id = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $usuario_id);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$userData = $result_usuario->fetch_assoc();

// BUSCA OS TÓPICOS CRIADOS PELO USUÁRIO
$sql_topicos = "SELECT id, titulo, conteudo, data_criacao FROM topicos WHERE usuario_id = ?";
$stmt_topicos = $conn->prepare($sql_topicos);
$stmt_topicos->bind_param("i", $usuario_id);
$stmt_topicos->execute();
$result_topicos = $stmt_topicos->get_result();

// BUSCA AS RESPOSTAS DO USUÁRIO
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
  <meta charset="UTF-8" />
  <title>Minha Conta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="icon" href="../escolas/img/logo.png" type="image/png">
  <link rel="stylesheet" href="../css/tema.css" />
  <script src="../js/tema.js" defer></script>
</head>
<body>

<header>
    <a class="logo"><img src="../escolas/img/logo.png" alt="Logo do site" />Fólio</a>
    <div class="bx bx-menu" id="menu-icon"></div>
    <ul class="navbar">
        <li><a href="../carta/carta.html">Home</a></li>
        <li><a href="../escolas/escolas.html">Escolas Literárias</a></li>
        <li><a href="../obras/obras.php">acervo literário</a></li>
        <li><a href="../forum/forum.php" class="active">Fórum</a></li>
        <li><a href="../perfil/perfil.php">Minha Conta</a></li>
        <li><a href="../sobre/sobre.php">Sobre</a></li>
    </ul>
</header>

<!-- CARD DE PERFIL -->
<div class="perfil-card">
  <div class="perfil-lado-esquerdo text-center">

    <!-- FOTO DE PERFIL -->
    <div class="foto-perfil" id="fotoPerfil">
      <img src="<?= htmlspecialchars(foto_perfil($userData['foto'] ?? null)) ?>" alt="Foto de perfil" id="imagemPerfil">
      <div class="editar-foto" onclick="abrirModalFotos()">✎</div>
    </div>

    <p><strong><?= htmlspecialchars($userData['username'] ?? 'Usuário') ?></strong></p>

    <div class="perfil-lado-esquerdo-bio">
      <p>"<?= htmlspecialchars($userData['bio'] ?? '') ?>"</p>
    </div>
  </div>

  <div class="perfil-lado-direito">
    <h2 style="margin-bottom: 20px;">Minha Conta</h2>

    <!-- Formulário de atualização -->
    <form id="form-perfil" action="atualizar_perfil.php" method="POST">
      <div class="form-row">
        <div class="form-group">
          <label>Nome</label>
          <input type="text" name="nome" value="<?= htmlspecialchars($userData['nome'] ?? '') ?>" required />
        </div>
        <div class="form-group">
          <label>Senha</label>
          <input type="password" name="senha" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Nome de usuário</label>
          <input type="text" name="username" value="<?= htmlspecialchars($userData['username'] ?? '') ?>" required />
        </div>
        <div class="form-group">
          <label>Confirme sua senha</label>
          <input type="password" name="confirma_senha" />
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($userData['email'] ?? '') ?>" required />
        </div>
        <div class="form-group">
          <label>Bio</label>
          <input type="text" name="bio" value="<?= htmlspecialchars($userData['bio'] ?? '') ?>" />
        </div>
      </div>

    </form>

<!-- BOTÕES -->
<div class="botoes-container perfil-botoes">
  <!-- Envia o formulário #form-perfil acima -->
  <button type="submit" form="form-perfil" class="btn-acao">Salvar</button>

  <!-- LINK SAIR -->
  <a href="logout.php" class="btn-acao btn-sec">Sair da Conta</a>

  <!-- FORM EXCLUIR (com confirmação) -->
  <form action="excluir_conta.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir sua conta?')" class="inline-form">
    <button type="submit" class="btn-acao1 btn-ter">Excluir Conta</button>
  </form>
</div>

  </div>
</div>

<!-- MODAL DE FOTOS -->
<div id="modalFotos" class="modal-fotos">
  <div class="modal-conteudo">
    <span class="fechar" onclick="fecharModalFotos()">&times;</span>
    <h3>Escolha sua foto de perfil</h3>
    <div class="grade-fotos">
      <img src="../perfil/img/foto1.jpeg" onclick="selecionarFoto('../perfil/img/foto1.jpeg')">
      <img src="../perfil/img/foto2.jpeg" onclick="selecionarFoto('../perfil/img/foto2.jpeg')">
      <img src="../perfil/img/foto3.jpeg" onclick="selecionarFoto('../perfil/img/foto3.jpeg')">
      <img src="../perfil/img/foto4.jpeg" onclick="selecionarFoto('../perfil/img/foto4.jpeg')">
    </div>
  </div>
</div>

<!-- LISTA DE TÓPICOS -->
<div class="meus-topicos">
  <h2>Meus Tópicos</h2>
</div>
<?php
$query = "SELECT t.*, u.username 
          FROM topicos t 
          JOIN usuarios u ON t.usuario_id = u.id 
          WHERE t.usuario_id = ? 
          ORDER BY t.data_criacao DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($t = $result->fetch_assoc()) {
        $topico_id = $t['id'];

        // Verifica se o usuário já votou neste tópico
        $check_vote = $conn->prepare("SELECT estrelas FROM votos_topicos WHERE usuario_id=? AND topico_id=?");
        $check_vote->bind_param("ii", $usuario_id, $topico_id);
        $check_vote->execute();
        $res_check = $check_vote->get_result();
        $usuario_votou = $res_check->num_rows > 0;
        $usuario_estrelas = $usuario_votou ? $res_check->fetch_assoc()['estrelas'] : 0;

        // Conta votos
        $res_votos = $conn->query("SELECT COUNT(*) AS votos FROM votos_topicos WHERE topico_id=$topico_id");
        $votos_data = $res_votos->fetch_assoc();
        $votos = intval($votos_data['votos']);

        echo "<div class='topico'>";
        echo "<strong><a href='../publico/perfil_publico.php?id=".$t['usuario_id']."'>@".htmlspecialchars($t['username'])."</a></strong> - <span>".htmlspecialchars($t['titulo'])."</span><br>";
        echo "<p>".nl2br(htmlspecialchars($t['conteudo']))."</p>";
        echo "<small>Criado em: ".date('d/m/Y H:i', strtotime($t['data_criacao']))."</small><br>";

        // Botão de exclusão
        echo "<a href='../forum/excluir_topico.php?id=".$t['id']."' class='text-danger' onclick=\"return confirm('Tem certeza que deseja excluir este tópico?')\">Excluir</a><br>";

        // Estrelas
        echo "<div class='estrelas' data-id='".$t['id']."' data-ja-votou='".($usuario_votou ? 1 : 0)."'>";
        for ($i = 1; $i <= 5; $i++) {
            $checked = $i <= ($usuario_votou ? $usuario_estrelas : intval($t['estrelas'])) ? 'checked' : '';
            echo "<span class='estrela $checked' data-value='$i'>★</span>";
        }
        echo " <span class='contador-votos' data-votos='$votos'>($votos votos)</span>";
        echo "</div>";

echo "<a href='../forum/ver_topico.php?id=".$t['id']."'>Ver tópico completo</a>";
        echo "</div>";
    }
} else {
    echo "<p class='text-muted' style='margin: 15px 10%;'>Você ainda não criou nenhum tópico.</p>";
}
?>
</div>

<style>
.estrelas { display: inline-block; margin-top: 5px; }
.estrela { font-size: 20px; cursor: pointer; color: #ccc; margin-right: 2px; transition: color 0.2s; }
.estrela.checked { color: gold; }
</style>

<script>
// Sistema de estrelas igual ao fórum
document.querySelectorAll('.estrela').forEach(e => {
    e.addEventListener('click', () => {
        const valor = e.getAttribute('data-value');
        const container = e.parentElement;
        const id = container.getAttribute('data-id');

        if (container.dataset.jaVotou == 1) {
            alert("⚠️ Você já votou neste tópico.");
            return;
        }

        container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = 'none');

        fetch('../forum/forum.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `topico_id=${encodeURIComponent(id)}&estrelas=${encodeURIComponent(valor)}`
        })
        .then(res => res.text())
        .then(text => {
            const res = text.trim();
            if (res === 'ok') {
                container.querySelectorAll('.estrela').forEach(star => {
                    star.classList.toggle('checked', parseInt(star.getAttribute('data-value')) <= parseInt(valor));
                });
                let votosSpan = container.querySelector('.contador-votos');
                if (votosSpan) {
                    let votos = parseInt(votosSpan.dataset.votos || '0') + 1;
                    votosSpan.dataset.votos = votos;
                    votosSpan.textContent = `(${votos} votos)`;
                }
                container.dataset.jaVotou = 1;
                alert('⭐ Voto registrado com sucesso!');
            } else if (res === 'ja_votou') {
                alert('⚠️ Você já votou neste tópico.');
            } else {
                alert('❌ Erro ao registrar voto.');
            }
            container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
        })
        .catch(err => {
            console.error(err);
            alert('❌ Erro de conexão.');
            container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
        });
    });
});
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

<!-- SCRIPTS -->
<script>
function abrirModalFotos() {
  document.getElementById('modalFotos').style.display = 'flex';
}
function fecharModalFotos() {
  document.getElementById('modalFotos').style.display = 'none';
}

function selecionarFoto(src) {
  const imagemPerfil = document.getElementById('imagemPerfil');
  imagemPerfil.src = src;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'salvar_foto.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  const usuarioId = <?= $usuario_id ?>;

  xhr.onload = function() {
    try {
      const resposta = JSON.parse(xhr.responseText);
      if (resposta.status === 'sucesso') {
        alert('Foto atualizada com sucesso!');
        const fotoNavbar = document.querySelector('.foto-navbar');
        if (fotoNavbar) fotoNavbar.src = src;
      } else {
        alert('Erro: ' + resposta.message);
      }
    } catch (e) {
      alert('Erro inesperado na resposta do servidor.');
    }
  };

  xhr.onerror = function() {
    alert('Erro de conexão com o servidor.');
  };

  xhr.send('foto=' + encodeURIComponent(src) + '&usuario_id=' + usuarioId);
  fecharModalFotos();
}
</script>

<script src="../js/contato.js"></script>
<?php
$mensagens_status = [
    'sucesso'          => 'Perfil atualizado com sucesso!',
    'erro'             => 'Erro ao atualizar o perfil. Tente novamente.',
    'erro_campos'      => 'Preencha nome, nome de usuário e um e-mail válido.',
    'erro_email'       => 'Este e-mail já está sendo usado por outra conta.',
    'erro_senha'       => 'As senhas não coincidem.',
    'erro_senha_fraca' => 'A nova senha deve ter pelo menos 8 caracteres, com letra maiúscula, minúscula, número e símbolo.',
];
if (isset($_GET['status'], $mensagens_status[$_GET['status']])): ?>
<script>alert(<?= json_encode($mensagens_status[$_GET['status']]) ?>);</script>
<?php endif; ?>
</body>
</html>
