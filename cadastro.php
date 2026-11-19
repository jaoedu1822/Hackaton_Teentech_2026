<?php
session_start();
 
// Se a pessoa já estiver logada, vai direto para o painel
if (isset($_SESSION["usuario_id"])) {
    header("Location: painel.php");
    exit;
}
 
// Erros que o processa_cadastro.php manda pela URL (ex.: cadastro.php?erro=existe)
// Cada código tem: [mensagem, campo que fica destacado em vermelho]
$mensagens = [
    "vazio"     => ["Preencha todos os campos para continuar.", "email"],
    "email"     => ["Digite um e-mail válido, por exemplo: nome@exemplo.com.", "email"],
    "existe"    => ["Este e-mail já está cadastrado. Tente entrar na sua conta.", "email"],
    "curta"     => ["A senha deve ter pelo menos 8 caracteres.", "password"],
    "diferente" => ["As senhas não coincidem. Digite novamente.", "confirm"],
    "termos"    => ["Para criar a conta, aceite os termos de uso e a política de privacidade.", "terms"],
    "banco"     => ["Não foi possível criar a conta agora. Tente novamente em instantes.", "email"],
];
 
$codigo = (isset($_GET["erro"]) && is_string($_GET["erro"])) ? $_GET["erro"] : "";
$erro   = $mensagens[$codigo] ?? null;
 
// Devolve " has-error" se o erro for daquele campo
function classeErro($campo, $erro) {
    return ($erro && $erro[1] === $campo) ? " has-error" : "";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar conta | Zagatec</title>
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
 
      --color-weak: #d92d20;
      --color-medium: #f79009;
      --color-strong: #27734f;
 
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
 
    .brand__list {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 28px;
      list-style: none;
    }
 
    .brand__item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      font-size: 0.9375rem;
      line-height: 1.5;
      color: rgba(255, 255, 255, 0.85);
    }
 
    .brand__check {
      flex-shrink: 0;
      display: grid;
      place-items: center;
      width: 22px;
      height: 22px;
      margin-top: 1px;
      color: #7fd9a8;
      background: rgba(127, 217, 168, 0.14);
      border-radius: 50%;
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
      padding: 44px 40px 32px;
      background: var(--color-surface);
      border: 1px solid rgba(16, 24, 40, 0.05);
      border-radius: var(--radius-card);
      box-shadow:
        0 1px 2px rgba(16, 24, 40, 0.04),
        0 16px 40px rgba(16, 24, 40, 0.08);
    }
 
    .auth__header {
      margin-bottom: 28px;
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
      gap: 20px;
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
 
    /* Campo com erro */
    .field.has-error .field__input {
      border-color: var(--color-error);
      background: var(--color-error-bg);
    }
 
    .field.has-error .field__input:focus {
      box-shadow: 0 0 0 4px rgba(180, 35, 24, 0.15);
    }
 
    .field.has-error .field__icon {
      color: var(--color-error);
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
 
    /* ===== Indicador de força da senha ===== */
    .strength {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 2px;
    }
 
    .strength__bars {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 6px;
      flex: 1;
    }
 
    .strength__bar {
      height: 4px;
      background: #e4e7ec;
      border-radius: 999px;
      transition: background-color 0.25s ease;
    }
 
    .strength[data-level="1"] .strength__bar:nth-child(-n+1) { background: var(--color-weak); }
    .strength[data-level="2"] .strength__bar:nth-child(-n+2) { background: var(--color-medium); }
    .strength[data-level="3"] .strength__bar:nth-child(-n+3) { background: var(--color-strong); }
 
    .strength__label {
      min-width: 64px;
      font-size: 0.8125rem;
      color: var(--color-muted);
      text-align: right;
    }
 
    /* ===== Checkbox de termos ===== */
    .check {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 0.875rem;
      line-height: 1.5;
      color: var(--color-muted);
    }
 
    .check__input {
      flex-shrink: 0;
      width: 18px;
      height: 18px;
      margin-top: 2px;
      accent-color: var(--color-primary);
      cursor: pointer;
    }
 
    .check__input:focus-visible {
      outline: 2px solid var(--color-primary);
      outline-offset: 2px;
    }
 
    .check.has-error {
      color: var(--color-error);
    }
 
    .check a {
      font-weight: 600;
      color: var(--color-primary);
      text-decoration: none;
    }
 
    .check a:hover {
      text-decoration: underline;
    }
 
    /* ===== Mensagem de erro ===== */
    .form__error {
      display: none;
      padding: 12px 14px;
      font-size: 0.875rem;
      line-height: 1.5;
      color: var(--color-error);
      background: var(--color-error-bg);
      border: 1px solid var(--color-error-border);
      border-radius: var(--radius-field);
    }
 
    .form__error.is-visible {
      display: block;
    }
 
    /* ===== Botão ===== */
    .button {
      height: 56px;
      margin-top: 4px;
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
 
    .form__note {
      font-size: 0.8125rem;
      line-height: 1.5;
      text-align: center;
      color: var(--color-muted);
    }
 
    /* ===== Rodapé do cartão ===== */
    .auth__footer {
      margin-top: 24px;
      padding-top: 22px;
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
        padding: 32px 22px 26px;
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
        <h2 class="brand__headline">Crie sua conta em poucos segundos.</h2>
        <p class="brand__text">
          Com uma conta, você acompanha o andamento do seu caso sem precisar se identificar publicamente.
        </p>
 
        <ul class="brand__list">
          <li class="brand__item">
            <span class="brand__check" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"></path></svg>
            </span>
            Não pedimos nome, CPF nem telefone.
          </li>
          <li class="brand__item">
            <span class="brand__check" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"></path></svg>
            </span>
            Seus dados são protegidos e tratados com sigilo.
          </li>
          <li class="brand__item">
            <span class="brand__check" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5 9-10"></path></svg>
            </span>
            Você pode parar a qualquer momento.
          </li>
        </ul>
      </div>
 
      <p class="brand__footer">© 2026 Zagatec. Todos os direitos reservados.</p>
    </aside>
 
    <!-- Área do formulário -->
    <main class="auth">
      <section class="auth__card" aria-labelledby="auth-title">
        <header class="auth__header">
          <h1 class="auth__title" id="auth-title">Criar conta</h1>
          <p class="auth__subtitle">Informe um e-mail e crie uma senha para começar.</p>
        </header>
 
        <!-- action: arquivo PHP que salva no banco | method POST: envia os dados sem mostrar na URL -->
        <form class="form" id="signup-form" action="processa_cadastro.php" method="POST" novalidate>
 
          <!-- E-mail -->
          <div class="field<?= classeErro('email', $erro) ?>" id="field-email">
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
 
          <!-- Senha (name="senha" precisa ser igual ao $_POST["senha"] do processa_cadastro.php) -->
          <div class="field<?= classeErro('password', $erro) ?>" id="field-password">
            <label class="field__label" for="password">Senha</label>
            <div class="field__control">
              <span class="field__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                  <path d="M8 11V7a4 4 0 0 1 8 0v4"></path>
                </svg>
              </span>
              <input
                class="field__input field__input--toggle"
                type="password"
                id="password"
                name="senha"
                placeholder="Mínimo de 8 caracteres"
                autocomplete="new-password"
                required
              >
              <button class="field__toggle" type="button" data-target="password" aria-label="Mostrar senha" aria-pressed="false">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>
 
            <div class="strength" id="strength" data-level="0" aria-live="polite">
              <div class="strength__bars" aria-hidden="true">
                <span class="strength__bar"></span>
                <span class="strength__bar"></span>
                <span class="strength__bar"></span>
              </div>
              <span class="strength__label" id="strength-label"></span>
            </div>
          </div>
 
          <!-- Confirmar senha -->
          <div class="field<?= classeErro('confirm', $erro) ?>" id="field-confirm">
            <label class="field__label" for="confirm">Confirmar senha</label>
            <div class="field__control">
              <span class="field__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                  <path d="M8 11V7a4 4 0 0 1 8 0v4"></path>
                </svg>
              </span>
              <input
                class="field__input field__input--toggle"
                type="password"
                id="confirm"
                name="confirm"
                placeholder="Repita a senha"
                autocomplete="new-password"
                required
              >
              <button class="field__toggle" type="button" data-target="confirm" aria-label="Mostrar senha" aria-pressed="false">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                  <circle cx="12" cy="12" r="3"></circle>
                </svg>
              </button>
            </div>
          </div>
 
          <!-- Termos -->
          <label class="check<?= classeErro('terms', $erro) ?>" id="field-terms">
            <input class="check__input" type="checkbox" id="terms" name="terms" value="1">
            <span>Li e aceito os <a href="ver_doc.php?doc=1.pdf" target="_blank" rel="noopener noreferrer">Termos de uso</a> e a <a href="ver_doc.php?doc=2.pdf" target="_blank" rel="noopener noreferrer">Política de privacidade</a>.</span>
          </label>
 
          <!-- Se o PHP mandou ?erro=... na URL, a mensagem já aparece visível -->
          <p class="form__error<?= $erro ? ' is-visible' : '' ?>" id="form-error" role="alert"><?= $erro ? htmlspecialchars($erro[0]) : '' ?></p>
 
          <button class="button" type="submit">Criar conta</button>
          <p class="form__note">Seu e-mail nunca é exibido publicamente.</p>
        </form>
 
        <footer class="auth__footer">
          <p>Já tem uma conta? <a class="auth__link" href="login.php">Entrar</a></p>
        </footer>
      </section>
    </main>
 
  </div>
 
  <script>
    /* ===== CONFIGURAÇÃO (troque aqui) ===== */
    const CONFIG = {
      minPasswordLength: 8 // precisa ser igual ao mínimo usado no processa_cadastro.php
    };
 
    const form = document.getElementById('signup-form');
    const errorBox = document.getElementById('form-error');
 
    const fields = {
      email: document.getElementById('field-email'),
      password: document.getElementById('field-password'),
      confirm: document.getElementById('field-confirm'),
      terms: document.getElementById('field-terms')
    };
 
    const inputs = {
      email: document.getElementById('email'),
      password: document.getElementById('password'),
      confirm: document.getElementById('confirm'),
      terms: document.getElementById('terms')
    };
 
    const strength = document.getElementById('strength');
    const strengthLabel = document.getElementById('strength-label');
 
    /* ===== Mostrar / ocultar senha (os dois campos) ===== */
    document.querySelectorAll('.field__toggle').forEach((button) => {
      button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.target);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(isHidden));
        button.setAttribute('aria-label', isHidden ? 'Ocultar senha' : 'Mostrar senha');
      });
    });
 
    /* ===== Força da senha ===== */
    function getStrength(password) {
      if (!password) return 0;
      let score = 0;
      if (password.length >= CONFIG.minPasswordLength) score++;
      if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
      if (/\d/.test(password) && /[^A-Za-z0-9]/.test(password)) score++;
      return Math.max(score, 1);
    }
 
    inputs.password.addEventListener('input', () => {
      const level = getStrength(inputs.password.value);
      const labels = ['', 'Fraca', 'Média', 'Forte'];
      strength.dataset.level = level;
      strengthLabel.textContent = labels[level];
    });
 
    /* ===== Erros ===== */
    function clearErrors() {
      errorBox.textContent = '';
      errorBox.classList.remove('is-visible');
      Object.values(fields).forEach((field) => field.classList.remove('has-error'));
    }
 
    function fail(fieldName, message) {
      fields[fieldName].classList.add('has-error');
      errorBox.textContent = message;
      errorBox.classList.add('is-visible');
      inputs[fieldName].focus();
    }
 
    Object.values(inputs).forEach((input) => {
      input.addEventListener('input', clearErrors);
      input.addEventListener('change', clearErrors);
    });
 
    /* ===== Validação e envio =====
       O JavaScript confere os campos antes de enviar (resposta rápida para quem usa).
       Quem confere de verdade e salva no banco é o PHP (processa_cadastro.php). */
    const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
 
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      clearErrors();
 
      const email = inputs.email.value.trim();
      const password = inputs.password.value;
      const confirm = inputs.confirm.value;
 
      if (!email) {
        return fail('email', 'Informe seu e-mail para continuar.');
      }
      if (!EMAIL_PATTERN.test(email)) {
        return fail('email', 'Digite um e-mail válido, por exemplo: nome@exemplo.com.');
      }
      if (!password) {
        return fail('password', 'Crie uma senha para continuar.');
      }
      if (password.length < CONFIG.minPasswordLength) {
        return fail('password', `A senha deve ter pelo menos ${CONFIG.minPasswordLength} caracteres.`);
      }
      if (!confirm) {
        return fail('confirm', 'Confirme sua senha.');
      }
      if (password !== confirm) {
        return fail('confirm', 'As senhas não coincidem. Digite novamente.');
      }
      if (!inputs.terms.checked) {
        fields.terms.classList.add('has-error');
        errorBox.textContent = 'Para criar a conta, aceite os termos de uso e a política de privacidade.';
        errorBox.classList.add('is-visible');
        inputs.terms.focus();
        return;
      }
 
      // Tudo certo: envia o formulário para o processa_cadastro.php
      form.submit();
    });
  </script>
</body>
</html>
 