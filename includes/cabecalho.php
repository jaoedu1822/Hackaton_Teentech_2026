<?php
/*
 * cabecalho.php — abre o HTML, mostra o menu e abre o <main>.
 * Cada página define $titulo_pagina e $pagina_atual ANTES de incluir este arquivo.
 * O rodape.php fecha o que este arquivo abre e reaproveita $menu e $nome_ong daqui.
 */

// Cookie de sessão com as proteções que discutimos (HttpOnly, SameSite).
// 'secure' só liga quando o site roda em HTTPS; no XAMPP (http) precisa ficar desligado.
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Strict',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

$nome_ong      = 'Zagatec'; // troque aqui e muda no site inteiro (cabeçalho e rodapé)
$titulo_pagina = $titulo_pagina ?? $nome_ong;
$pagina_atual  = $pagina_atual ?? '';
$logado        = isset($_SESSION['usuario_id']);

/*
 * O menu fica em UM array. O cabeçalho e o rodapé fazem um laço (foreach) sobre ele,
 * então para adicionar ou remover uma aba basta mexer aqui.
 * A chave (ex.: 'denunciar') é comparada com $pagina_atual para destacar a aba da página aberta.
 * Páginas ainda não criadas: acompanhar.php, sobre.php, doacoes.php (ajuste os nomes se forem outros).
 */
$menu = [
    'denunciar'     => ['href' => 'https://rede-escudo.onrender.com/',           'texto' => 'Denunciar'],
    'acompanhar'    => ['href' => 'acompanhar.php',          'texto' => 'Acompanhar caso'],
    'sobre'         => ['href' => 'sobre.php',               'texto' => 'Sobre nós'],
    'doacoes'       => ['href' => 'doacoes.php',             'texto' => 'Doações'],
];

// A última aba depende de a pessoa estar logada ou não
if ($logado) {
    $menu['sair']  = ['href' => 'logout.php', 'texto' => 'Sair da conta'];
} else {
    $menu['login'] = ['href' => 'login.php',  'texto' => 'Login'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($titulo_pagina) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700;800&display=swap">
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="Imagens/logo-zagatec.png">
  <link rel="apple-touch-icon" href="Imagens/logo-zagatec.png">
</head>
<body>
  <a class="pular-conteudo" href="#conteudo">Pular para o conteúdo</a>

  <header class="cabecalho">
    <div class="container">
      <a class="marca" href="index.php">
        <span class="marca-icone" aria-hidden="true">
          <img src="Imagens/logo-zagatec.png" alt="" width="36" height="36">
        </span>
        <?= htmlspecialchars($nome_ong) ?>
      </a>

      <div class="cabecalho-acoes">
        <nav class="nav-principal" aria-label="Principal">
          <?php foreach ($menu as $chave => $item): ?>
            <a href="<?= htmlspecialchars($item['href']) ?>"<?= $chave === $pagina_atual ? ' aria-current="page"' : '' ?>><?= htmlspecialchars($item['texto']) ?></a>
          <?php endforeach; ?>
        </nav>

        <!-- O JavaScript (js/main.js) liga este botão. Também funciona com Esc duas vezes. -->
        <button type="button" id="saida-rapida" class="btn-saida" aria-label="Sair rápido: fecha este site agora. Atalho: tecla Esc duas vezes">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" aria-hidden="true" focusable="false"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Sair rápido
        </button>
      </div>
    </div>
  </header>

  <main id="conteudo">
