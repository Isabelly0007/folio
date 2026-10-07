<?php
require_once __DIR__ . '/../conexao.php';

exigir_login();
$usuario_id = $_SESSION['usuario_id'];

// Busca username do usuário logado
$sql_user = "SELECT username FROM usuarios WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $usuario_id);
$stmt_user->execute();
$res_user = $stmt_user->get_result();
$row_user = $res_user->fetch_assoc();
$username = $row_user['username'];

// --- REGISTRO DE VOTO (usado pelo fórum, pela página do tópico e pelo perfil) ---
if (isset($_POST['topico_id'], $_POST['estrelas'])) {
    $topico_id = (int) $_POST['topico_id'];
    $estrelas = (int) $_POST['estrelas'];

    if ($estrelas < 1 || $estrelas > 5) {
        echo "erro";
        exit;
    }

    // Verifica se o usuário já votou neste tópico
    $check = $conn->prepare("SELECT id FROM votos_topicos WHERE usuario_id = ? AND topico_id = ?");
    $check->bind_param("ii", $usuario_id, $topico_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "ja_votou"; // Já votou antes
        exit;
    }

    // Registra o voto
    $insert = $conn->prepare("INSERT INTO votos_topicos (usuario_id, topico_id, estrelas) VALUES (?, ?, ?)");
    $insert->bind_param("iii", $usuario_id, $topico_id, $estrelas);
    $insert->execute();

    // Atualiza a média de estrelas do tópico
    $media = $conn->prepare("UPDATE topicos
                             SET estrelas = (SELECT ROUND(AVG(estrelas)) FROM votos_topicos WHERE topico_id = ?)
                             WHERE id = ?");
    $media->bind_param("ii", $topico_id, $topico_id);
    $media->execute();

    echo "ok";
    exit;
}

// --- FILTROS (substituir bloco anterior) ---
$busca = $_GET['busca'] ?? '';
$filtro_campo = $_GET['campo'] ?? '';
$filtro_estrelas = $_GET['estrelas'] ?? '';
$ordem = $_GET['ordem'] ?? 'novas';

// Vamos montar a query principal usando um LEFT JOIN com uma subquery que calcula média e contagem reais
$sql = "SELECT topicos.*, usuarios.username,
               vt.media AS media_estrelas,
               vt.votos AS votos_reais
        FROM topicos
        JOIN usuarios ON topicos.usuario_id = usuarios.id
        LEFT JOIN (
            SELECT topico_id,
                   ROUND(AVG(estrelas)) AS media,
                   COUNT(*) AS votos
            FROM votos_topicos
            GROUP BY topico_id
        ) vt ON vt.topico_id = topicos.id
        WHERE 1";

// Filtro por palavra-chave (escapando)
if (!empty($busca)) {
    $busca_sql = $conn->real_escape_string($busca);
    if ($filtro_campo === 'titulo') {
        $sql .= " AND topicos.titulo LIKE '%$busca_sql%'";
    } else if ($filtro_campo === 'obra_relacionada') {
        $sql .= " AND topicos.obra_relacionada LIKE '%$busca_sql%'";
    } else {
        $sql .= " AND (topicos.titulo LIKE '%$busca_sql%'
                      OR topicos.conteudo LIKE '%$busca_sql%'
                      OR topicos.obra_relacionada LIKE '%$busca_sql%')";
    }
}

// Filtro por estrelas (usando a média calculada na subquery)
// Observação: só vai mostrar tópicos que têm votos — se quiser incluir sem-votos, remova "vt.media IS NOT NULL"
if ($filtro_estrelas !== '') {
    $filtro = intval($filtro_estrelas);
    $sql .= " AND vt.media IS NOT NULL AND vt.media = $filtro";
}

// Ordenação
switch ($ordem) {
    case 'estrelas':
        // Ordena pela média calculada; se preferir usar topicos.estrelas, troque para topicos.estrelas DESC
        $sql .= " ORDER BY COALESCE(vt.media, 0) DESC, vt.votos DESC";
        break;
    case 'antigas':
        $sql .= " ORDER BY topicos.data_criacao ASC";
        break;
    case 'titulo':
        $sql .= " ORDER BY topicos.titulo ASC";
        break;
    case 'autor':
        $sql .= " ORDER BY usuarios.username ASC";
        break;
    case 'obra':
        $sql .= " ORDER BY topicos.obra_relacionada ASC";
        break;
    default: // novas
        $sql .= " ORDER BY topicos.data_criacao DESC";
}

$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Fórum Literário</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <link rel="icon" href="../escolas/img/logo.png" type="image/png">
  <style>
    .estrelas { display: inline-block; }
    .estrela { font-size: 20px; cursor: pointer; color: #ccc; margin-right: 2px; }
    .estrela.checked { color: gold; }
    .topico { border: 1px solid #ddd; padding: 10px; margin-bottom: 15px; border-radius: 5px; }
    .topico strong { color: #333; }
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

<!-- HEADER DO FÓRUM -->
<div class="forum-header">
  <h2>FÓRUM DE CONVERSA</h2>
  <p>Discuta livros, autores e conteúdos literários com outros membros da comunidade.</p>
</div>

<!-- FILTRO DE POSTAGENS -->

<form class="filtro-container" method="get">
    <div class="section-title">Filtrar tópicos</div>

  <input type="text" name="busca" placeholder="Buscar..." value="<?= htmlspecialchars($busca) ?>">
  
  <select name="estrelas">
    <option value="">Qualquer estrela</option>
    <option value="1" <?= $filtro_estrelas==1?'selected':'' ?>>1 ★</option>
    <option value="2" <?= $filtro_estrelas==2?'selected':'' ?>>2 ★</option>
    <option value="3" <?= $filtro_estrelas==3?'selected':'' ?>>3 ★</option>
    <option value="4" <?= $filtro_estrelas==4?'selected':'' ?>>4 ★</option>
    <option value="5" <?= $filtro_estrelas==5?'selected':'' ?>>5 ★</option>
  </select>

  <select name="ordem">
      <option value="novas" <?= $ordem=='novas'?'selected':'' ?>>Mais novas</option>
      <option value="antigas" <?= $ordem=='antigas'?'selected':'' ?>>Mais antigas</option>
      <option value="estrelas" <?= $ordem=='estrelas'?'selected':'' ?>>Mais avaliadas</option>
  </select>
  <button type="submit">Filtrar</button>
  <button type="button" onclick="window.location.href='forum.php'">Limpar</button>
</form>

<!-- FORMULÁRIO DE NOVO TÓPICO -->
<div class="topico">
  <form action="criar_topico.php" method="post">
  <div class="section-title">Criar tópicos</div>
    <input type="text" name="titulo" placeholder="Título do tópico" required><br>
    <input type="text" name="obra_relacionada" placeholder="Obra relacionada" required><br>
    <textarea name="conteudo" placeholder="Escreva aqui seu tópico..." required></textarea><br>
    <button type="submit">Postar</button>
  </form>
</div>

<!-- LISTA DE TÓPICOS -->
<div class="lista-topicos">
<?php
if ($result->num_rows > 0) {
    while ($t = $result->fetch_assoc()) {
        echo "<div class='topico'>";
        echo "<strong><a href='../publico/perfil_publico.php?id=".$t['usuario_id']."'>@".htmlspecialchars($t['username'])."</a></strong> - <span>".htmlspecialchars($t['titulo'])."</span><br>";
        echo "<p>".nl2br(htmlspecialchars($t['conteudo']))."</p>";
        echo "<small>Obra: ".htmlspecialchars($t['obra_relacionada'] ?: 'Não informada')." | Criado em: ".$t['data_criacao']."</small><br>";

        if ($t['usuario_id'] == $usuario_id) {
            echo "<a href='excluir_topico.php?id=".$t['id']."' onclick=\"return confirm('Deseja realmente excluir este tópico?')\">Excluir</a><br>";
        }

        // --- ESTRELAS E CONTADOR ---
$topico_id = $t['id'];

// Verifica se o usuário já votou neste tópico e quantas estrelas ele deu
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

// Cria o container de estrelas
echo "<div class='estrelas' data-id='".$t['id']."' data-ja-votou='".($usuario_votou ? 1 : 0)."'>";

// Exibe 5 estrelas, preenchendo as amarelas (checked) até a quantidade que o usuário votou ou a média atual
for ($i = 1; $i <= 5; $i++) {
    $checked = $i <= ($usuario_votou ? $usuario_estrelas : intval($t['estrelas'])) ? 'checked' : '';
    echo "<span class='estrela $checked' data-value='$i'>★</span>";
}

// Mostra contador de votos
echo " <span class='contador-votos' data-votos='$votos'>($votos votos)</span>";
echo "</div>";

// Link para ver tópico completo
echo "<a href='ver_topico.php?id=".$t['id']."'>Ver tópico completo</a>";
echo "</div>";
    }
}
?>
</div>

<script>
document.querySelectorAll('.estrela').forEach(e => {
    e.addEventListener('click', () => {
        const valor = e.getAttribute('data-value');
        const container = e.parentElement;
        const id = container.getAttribute('data-id');

        // Bloqueia se já votou
        if (container.dataset.jaVotou == 1) {
            alert("⚠️ Você já votou neste tópico.");
            return;
        }

        // Desabilita cliques rápidos
        container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = 'none');

        fetch('forum.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded'},
            body: `topico_id=${encodeURIComponent(id)}&estrelas=${encodeURIComponent(valor)}`
        })
        .then(res => res.text())
        .then(text => {
            const res = text.trim();
            if (res === 'ja_votou') {
                alert('⚠️ Você já votou neste tópico.');
                container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
                return;
            }
            if (res === 'ok') {
                container.querySelectorAll('.estrela').forEach(star => {
                    star.classList.toggle('checked', parseInt(star.getAttribute('data-value')) <= parseInt(valor));
                });

                // Atualiza contador
                let votosSpan = container.querySelector('.contador-votos');
                if (votosSpan) {
                    let votos = parseInt(votosSpan.dataset.votos || '0') + 1;
                    votosSpan.dataset.votos = votos;
                    votosSpan.textContent = `(${votos} votos)`;
                }

                container.dataset.jaVotou = 1;
                alert('⭐ Voto registrado com sucesso!');
            } else {
                console.error('Resposta inesperada do servidor:', text);
                alert('❌ Erro ao registrar voto.');
            }
            container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
        })
        .catch(err => {
            console.error(err);
            alert('❌ Erro de conexão. Tente novamente.');
            container.querySelectorAll('.estrela').forEach(s => s.style.pointerEvents = '');
        });
    });
});
let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");

// Toggle menu mobile
menu.onclick = () => {
  menu.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};

// Remove menu ativo ao dar scroll na página
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

<script src="../js/contato.js"></script>
</body>
</html>
