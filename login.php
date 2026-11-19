<?php
session_start();
 
// Se a pessoa já estiver logada, vai direto para o painel
if (isset($_SESSION["usuario_id"])) {
    header("Location: painel.php");
    exit;
}
 
// Avisos que vêm pela URL (ex.: login.php?erro=1 ou login.php?cadastro=ok)
$temErro    = isset($_GET["erro"]);
$cadastroOk = isset($_GET["cadastro"]);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acesso | Zagatec</title>
  <link rel="icon" type="image/png" href="Imagens/logo-zagatec.png">
  <link rel="apple-touch-icon" href="Imagens/logo-zagatec.png">
 
  <style>
    /* ===== Variáveis ===== */
    :root {
      --teal-900: #0f2a38;
      --teal-800: #163a4d;
      --teal-700: #1c4a60;
 
      --color-bg: #f4f6f7;
      --color-surface: #ffffff;
      --color-text: #151b28;
      --color-muted: #5d6779;
      --color-field-bg: #f7f8fa;
      --color-border: #dfe3ea;
 
      --color-primary: #27734f;
      --color-primary-dark: #1d5a3e;
      --color-focus-ring: rgba(39, 115, 79, 0.2);
 
      --color-error: #b42318;
      --color-error-bg: #fef3f2;
      --color-error-border: #fecdca;
 
      --color-success: #1d5a3e;
      --color-success-bg: #ecfdf3;
      --color-success-border: #a6e9c4;
 
      --radius-card: 24px;
      --radius-field: 10px;
      --radius-button: 999px;
 
      --font-family: "Inter", "Segoe UI", system-ui, -apple-system, Roboto, Arial, sans-serif;
    }
 
    /* ===== Reset ===== */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
 
    body {
      min-height: 100vh;
      font-family: var(--font-family);
      color: var(--color-text);
      background: var(--color-bg);
      -webkit-font-smoothing: antialiased;
    }
 
    /* ===== Estrutura geral ===== */
    .page {
      display: grid;
      grid-template-columns: minmax(360px, 5fr) 6fr;
      min-height: 100vh;
    }
 
    /* ===== Painel institucional ===== */
    .brand {
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 32px;
      padding: 48px 56px;
      overflow: hidden;
      color: #fff;
      background: linear-gradient(155deg, var(--teal-700) 0%, var(--teal-800) 45%, var(--teal-900) 100%);
    }
 
    .brand::before,
    .brand::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      pointer-events: none;
    }
 
    .brand::before {
      width: 420px;
      height: 420px;
      right: -160px;
      top: -140px;
      background: radial-gradient(circle, rgba(70, 170, 120, 0.25) 0%, transparent 70%);
    }
 
    .brand::after {
      width: 360px;
      height: 360px;
      left: -140px;
      bottom: -120px;
      border: 1px solid rgba(255, 255, 255, 0.08);
      box-shadow: 0 0 0 48px rgba(255, 255, 255, 0.025);
    }
 
    .brand > * {
      position: relative;
      z-index: 1;
    }
 
    .brand__logo {
      display: flex;
      align-items: center;
      gap: 12px;
    }
 
    .brand__mark {
      display: grid;
      place-items: center;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 12px;
    }
 
    .brand__name {
      font-size: 1.125rem;
      font-weight: 600;
      letter-spacing: -0.01em;
    }
 
    .brand__content {
      max-width: 420px;
    }
 
    .brand__headline {
      font-size: 2.25rem;
      font-weight: 600;
      line-height: 1.2;
      letter-spacing: -0.02em;
    }
 
    .brand__text {
      margin-top: 16px;
      font-size: 1rem;
      line-height: 1.65;
      color: rgba(255, 255, 255, 0.75);
    }
 
    .brand__alert {
      margin-top: 28px;
      padding: 14px 16px;
      font-size: 0.875rem;
      line-height: 1.5;
      color: rgba(255, 255, 255, 0.85);
      background: rgba(255, 255, 255, 0.07);
      border: 1px solid rgba(255, 255, 255, 0.14);
      border-radius: 12px;
    }
 
    .brand__alert strong {
      color: #fff;
    }
 
    .brand__footer {
      font-size: 0.8125rem;
      color: rgba(255, 255, 255, 0.5);
    }
 
    /* ===== Área do formulário ===== */
    .auth {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
    }
 
    .auth__card {
      width: 100%;
      max-width: 440px;
      padding: 48px 40px 36px;
      background: var(--color-surface);
      border: 1px solid rgba(16, 24, 40, 0.05);
      border-radius: var(--radius-card);
      box-shadow:
        0 1px 2px rgba(16, 24, 40, 0.04),
        0 16px 40px rgba(16, 24, 40, 0.08);
    }
 
    .auth__header {
      margin-bottom: 32px;
    }
 
    .auth__title {
      font-size: 1.75rem;
      font-weight: 600;
      letter-spacing: -0.02em;
      line-height: 1.2;
    }
 
    .auth__subtitle {
      margin-top: 8px;
      font-size: 0.9375rem;
      line-height: 1.5;
      color: var(--color-muted);
    }
 
    /* ===== Formulário ===== */
    .form {
      display: flex;
      flex-direction: column;
      gap: 22px;
    }
 
    .field {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
 
    .field__label {
      font-size: 0.875rem;
      font-weight: 500;
      color: #394150;
    }
 
    .field__control {
      position: relative;
    }
 
    .field__icon {
      position: absolute;
      top: 50%;
      left: 16px;
      display: grid;
      place-items: center;
      color: #8a93a3;
      transform: translateY(-50%);
      pointer-events: none;
      transition: color 0.2s ease;
    }
 
    .field__input {
      width: 100%;
      height: 52px;
      padding: 0 16px 0 46px;
      font: inherit;
      font-size: 1rem;
      color: var(--color-text);
      background: var(--color-field-bg);
      border: 1px solid var(--color-border);
      border-radius: var(--radius-field);
      transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
    }
 
    .field__input::placeholder {
      color: #8a93a3;
    }
 
    .field__input:hover {
      border-color: #cbd1db;
    }
 
    .field__input:focus {
      outline: none;
      background: var(--color-surface);
      border-color: var(--color-primary);
      box-shadow: 0 0 0 4px var(--color-focus-ring);
    }
 
    .field__control:focus-within .field__icon {
      color: var(--color-primary);
    }
 
    .field__input--toggle {
      padding-right: 50px;
    }
 
    .field__toggle {
      position: absolute;
      top: 50%;
      right: 8px;
      display: grid;
      place-items: center;
      width: 36px;
      height: 36px;
      color: var(--color-muted);
      background: none;
      border: 0;
      border-radius: 50%;
      cursor: pointer;
      transform: translateY(-50%);
      transition: color 0.2s ease, background-color 0.2s ease;
    }
 
    .field__toggle:hover {
      color: var(--color-text);
      background: rgba(16, 24, 40, 0.06);
    }
 
    .field__toggle:focus-visible {
      outline: 2px solid var(--color-primary);
      outline-offset: 2px;
    }
 
    /* ===== Mensagens de erro e sucesso ===== */
    .form__error,
    .form__success {
      display: none;
      padding: 12px 14px;
      font-size: 0.875rem;
      line-height: 1.5;
      border-radius: var(--radius-field);
    }
 
    .form__error {
      color: var(--color-error);
      background: var(--color-error-bg);
      border: 1px solid var(--color-error-border);
    }
 
    .form__success {
      color: var(--color-success);
      background: var(--color-success-bg);
      border: 1px solid var(--color-success-border);
    }
 
    .form__error.is-visible,
    .form__success.is-visible {
      display: block;
    }
 
    /* ===== Botão ===== */
    .button {
      height: 56px;
      margin-top: 6px;
      font: inherit;
      font-size: 1.0625rem;
      font-weight: 600;
      color: #fff;
      background: linear-gradient(180deg, #2f8059 0%, var(--color-primary) 100%);
      border: 0;
      border-radius: var(--radius-button);
      cursor: pointer;
      box-shadow: 0 6px 16px rgba(39, 115, 79, 0.28);
      transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
 
    .button:hover {
      background: var(--color-primary-dark);
      box-shadow: 0 10px 24px rgba(39, 115, 79, 0.36);
      transform: translateY(-1px);
    }
 
    .button:active {
      transform: translateY(0);
      box-shadow: 0 4px 10px rgba(39, 115, 79, 0.28);
    }
 
    .button:focus-visible {
      outline: 3px solid var(--color-focus-ring);
      outline-offset: 3px;
    }
 
    /* ===== Rodapé do cartão ===== */
    .auth__footer {
      margin-top: 28px;
      padding-top: 24px;
      text-align: center;
      font-size: 0.9375rem;
      color: var(--color-muted);
      border-top: 1px solid #edf0f4;
    }
 
    .auth__link {
      font-weight: 600;
      color: var(--color-primary);
      text-decoration: none;
      border-radius: 4px;
      transition: color 0.2s ease;
    }
 
    .auth__link:hover {
      color: var(--color-primary-dark);
      text-decoration: underline;
    }
 
    .auth__link:focus-visible {
      outline: 2px solid var(--color-primary);
      outline-offset: 3px;
    }
 
    /* ===== Tablets e telas menores ===== */
    @media (max-width: 960px) {
      .page {
        grid-template-columns: 1fr;
        grid-template-rows: auto 1fr;
      }
 
      .brand {
        padding: 24px 28px;
      }
 
      .brand__content,
      .brand__footer {
        display: none;
      }
 
      .auth {
        padding: 32px 20px 48px;
      }
    }
 
    /* ===== Celulares ===== */
    @media (max-width: 480px) {
      .brand {
        padding: 20px;
      }
 
      .auth {
        padding: 24px 16px 40px;
      }
 
      .auth__card {
        padding: 32px 22px 28px;
        border-radius: 20px;
      }
 
      .auth__title {
        font-size: 1.5rem;
      }
 
      .field__input {
        height: 50px;
      }
 
      .button {
        height: 52px;
      }
    }
 
    /* Respeita preferência por menos movimento */
    @media (prefers-reduced-motion: reduce) {
      * {
        transition: none !important;
      }
    }
  </style>
</head>
 
<body>
  <div class="page">
 
    <!-- Painel institucional -->
    <aside class="brand">
      <div class="brand__logo">
        <span class="brand__mark" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2l8 3v6c0 5-3.4 9.3-8 11-4.6-1.7-8-6-8-11V5l8-3z"></path>
            <path d="M9 12l2 2 4-4"></path>
          </svg>
        </span>
        <span class="brand__name">Zagatec</span>
      </div>
 
      <div class="brand__content">
        <h2 class="brand__headline">Você não está sozinha(o).</h2>
        <p class="brand__text">
          Canal anônimo de denúncia e apoio a vítimas de crimes em grupos online.
          Seu relato é analisado por uma equipe especializada e encaminhado às autoridades.
        </p>
 
        <div class="brand__alert">
          <strong>Está em perigo agora?</strong> Ligue <strong>190</strong> (emergência)
          ou <strong>188</strong> (CVV, apoio emocional 24 horas).
        </div>
      </div>
 
      <p class="brand__footer">© 2026 Zagatec. Todos os direitos reservados.</p>
    </aside>
 
    <!-- Área do formulário -->
    <main class="auth">
      <section class="auth__card" aria-labelledby="auth-title">
        <header class="auth__header">
          <h1 class="auth__title" id="auth-title">Acesse sua conta</h1>
          <p class="auth__subtitle">Acompanhe seu caso com segurança e anonimato.</p>
        </header>
 
        <!-- action: arquivo PHP que confere o login | method POST: envia os dados sem mostrar na URL -->
        <form class="form" id="login-form" action="processa_login.php" method="POST" novalidate>
 
          <?php if ($cadastroOk): ?>
            <p class="form__success is-visible" id="form-success" role="status">
              Conta criada com sucesso! Faça login para continuar.
            </p>
          <?php endif; ?>
 
          <div class="field">
            <label class="field__label" for="email">E-mail</label>
            <div class="field__control">
              <span class="field__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                  <path d="M3 7l9 6 9-6"></path>
                </svg>
              </span>
              <input
                class="field__input"
                type="email"
                id="email"
                name="email"
                placeholder="seuemail@exemplo.com"
                autocomplete="email"
                required
              >
            </div>
          </div>
 
          <div class="field">
            <label class="field__label" for="password">Senha</label>
            <div class="field__control">
              <span class="field__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                  <path d="M8 11V7a4 4 0 0 1 8 0v4"></path>
                </svg>
              </span>
              <!-- name="senha" precisa ser igual ao $_POST["senha"] do processa_login.php -->
              <input
                class="field__input field__input--toggle"
                type="password"
                id="password"
                name="senha"
                placeholder="Digite sua senha"
                autocomplete="current-password"
                required
              >
              <button class="field__toggle" type="button" aria-label="Mostrar senha" aria-pressed="false">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>
          </div>
 
          <!-- Se o PHP mandou erro=1 na URL, a mensagem já aparece visível -->
          <p class="form__error<?= $temErro ? ' is-visible' : '' ?>" id="form-error" role="alert"><?= $temErro ? 'E-mail ou senha incorretos. Tente novamente.' : '' ?></p>
 
          <button class="button" type="submit">Entrar</button>
        </form>
 
        <footer class="auth__footer">
          <p>Não tem uma conta? <a class="auth__link" href="cadastro.php">Criar</a></p>
        </footer>
      </section>
    </main>
 
  </div>
 
  <script>
    const form = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const errorBox = document.getElementById('form-error');
    const successBox = document.getElementById('form-success');
    const toggle = document.querySelector('.field__toggle');
 
    /* Mostrar / ocultar senha */
    toggle.addEventListener('click', () => {
      const isHidden = passwordInput.type === 'password';
      passwordInput.type = isHidden ? 'text' : 'password';
      toggle.setAttribute('aria-pressed', String(isHidden));
      toggle.setAttribute('aria-label', isHidden ? 'Ocultar senha' : 'Mostrar senha');
    });
 
    /* Mensagem de erro */
    function showError(message) {
      errorBox.textContent = message;
      errorBox.classList.add('is-visible');
    }
 
    function clearError() {
      errorBox.textContent = '';
      errorBox.classList.remove('is-visible');
      if (successBox) {
        successBox.classList.remove('is-visible');
      }
    }
 
    emailInput.addEventListener('input', clearError);
    passwordInput.addEventListener('input', clearError);
 
    /* Envio do formulário:
       o JavaScript só confere se os campos estão preenchidos.
       Quem confere e-mail e senha de verdade agora é o PHP (processa_login.php). */
    form.addEventListener('submit', (event) => {
      const email = emailInput.value.trim();
      const password = passwordInput.value;
 
      if (!email || !password) {
        event.preventDefault(); // só bloqueia o envio se estiver vazio
        showError('Preencha o e-mail e a senha para continuar.');
      }
      // se estiver preenchido, o formulário segue normalmente para o processa_login.php
    });
      
      $_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['logado'] = true;

header("Location: painel.php"); // ou a página que quiser
exit;
      
      $_SESSION['usuario_id'] = $usuario['id'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['logado'] = true;

// Se o usuário tentou acompanhar caso antes de logar
if (!empty($_SESSION['redirect_depois_login'])) {
    $destino = $_SESSION['redirect_depois_login'];
    unset($_SESSION['redirect_depois_login']);
    header("Location: " . $destino);
    exit;
}

header("Location: painel.php");
exit;
  </script>
</body>
</html>
 