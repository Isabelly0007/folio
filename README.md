# Fólio — Literatura Brasileira

> Comece sua jornada pela literatura.

O **Fólio** é um site para estudantes e vestibulandos aprenderem sobre a **literatura brasileira**, conversarem sobre livros e baixarem obras gratuitamente. Foi desenvolvido como Trabalho de Conclusão de Curso (TCC) do curso técnico em Desenvolvimento de Sistemas da **ETEC**.

## Funcionalidades

- **Escolas literárias**: uma página para cada movimento, do Quinhentismo ao Pós-Modernismo, com contexto histórico, características, exemplos de obras e os principais autores.
- **A Carta de Pero Vaz de Caminha**: página especial sobre o marco inicial da literatura no Brasil.
- **Acervo literário**: cerca de 180 obras e 40 autores, com busca por título, autor ou escola. As obras em domínio público têm link de download direto do portal [Domínio Público](http://www.dominiopublico.gov.br). Para as demais, o site sugere bibliotecas públicas próximas (via geolocalização).
- **Fórum**: os usuários criam tópicos sobre obras, respondem, avaliam com estrelas (1 a 5) e filtram por palavra-chave, nota ou data.
- **Contas de usuário**: cadastro com validação de senha forte, login, perfil com foto e bio, perfil público, recuperação de senha por e-mail e exclusão de conta.
- **Fale Conosco**: formulário no rodapé que envia mensagens por e-mail.

## Tecnologias

| Camada | Tecnologia |
|---|---|
| Front-end | HTML5, CSS3, JavaScript, Bootstrap 5, Boxicons, SweetAlert2 |
| Back-end | PHP 8 (mysqli) |
| Banco de dados | MySQL / MariaDB |
| E-mail | PHPMailer (SMTP do Gmail) |

## Como rodar no seu computador

### 1. Instale o XAMPP
Baixe em <https://www.apachefriends.org> e inicie o **Apache** e o **MySQL** no painel do XAMPP.

### 2. Coloque o projeto na pasta do servidor
Copie (ou clone) esta pasta para `C:\xampp\htdocs\folio`:

```bash
git clone https://github.com/SEU-USUARIO/folio.git C:/xampp/htdocs/folio
```

### 3. Crie o banco de dados
Abra <http://localhost/phpmyadmin>, vá em **Importar** e selecione o arquivo [`database/folio.sql`](database/folio.sql).
Ele cria o banco `literatura` com todas as tabelas, os autores e as obras.

### 4. Configure
Faça uma cópia de `config.example.php` com o nome **`config.php`** e preencha:
- os dados do banco (no XAMPP o padrão já funciona: usuário `root`, sem senha);
- um e-mail do Gmail e uma [senha de app](https://myaccount.google.com/apppasswords), usados no "Fale Conosco" e na recuperação de senha (opcional para testar o resto do site).

### 5. Acesse
<http://localhost/folio>

## Estrutura de pastas

```
├── index.php                # entrada do site (redireciona para o login ou para a Home)
├── conexao.php              # conexão com o banco + funções auxiliares
├── config.example.php       # modelo de configuração (copie para config.php)
├── email.php                # configuração do PHPMailer
├── cadastro.php / login.php # cadastro e login (respondem em JSON)
├── enviar_email.php         # formulário "Fale Conosco"
├── database/folio.sql       # estrutura do banco + acervo
├── inicial/                 # página de boas-vindas com login e cadastro
├── carta/                   # Home: a Carta de Pero Vaz de Caminha
├── escolas/                 # lista das escolas literárias
├── quinhentismo/ … pos-modernismo/  # uma página por escola literária
├── obras/                   # acervo (capas e fotos dos autores)
├── forum/                   # fórum: tópicos, respostas e estrelas
├── perfil/                  # Minha Conta
├── publico/                 # perfil público dos usuários
├── recuperar_senha/         # fluxo de "esqueci minha senha"
├── sobre/                   # sobre o projeto e a equipe
├── sobre_app/, politica_app/  # páginas usadas pelo aplicativo
├── css/tema.css             # acabamento visual compartilhado (fontes, formas e animações)
├── js/tema.js               # animações ao rolar e destaque do menu
├── imagens/, js/            # arquivos compartilhados
└── phpmailer-master/        # biblioteca PHPMailer
```

## Equipe

- Isabelly Pereira de França
- Sabrina Costa
- Thabata Oliveira
- Thais Mamani Rodriguez

---

As obras disponibilizadas para download são de **domínio público** e foram obtidas do portal Domínio Público, do Governo Federal.
