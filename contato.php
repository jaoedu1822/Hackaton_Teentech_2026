<?php
$titulo_pagina = 'Contato | Zagatec';
$pagina_atual  = 'contato.php';

$enviado  = false;
$erro     = '';
$nome     = '';
$email    = '';
$assunto  = '';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $armadilha = trim($_POST['website'] ?? '');
  $nome      = trim($_POST['nome'] ?? '');
  $email     = trim($_POST['email'] ?? '');
  $assunto   = trim($_POST['assunto'] ?? '');
  $mensagem  = trim($_POST['mensagem'] ?? '');

  if ($armadilha !== '') {
    $enviado = true;
  } elseif ($assunto === '' || $mensagem === '') {
    $erro = 'Por favor, selecione um assunto e escreva sua mensagem.';
  } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = 'O endereço de e-mail informado não parece válido.';
  } else {
    $destino = 'zagatec.osc@gmail.com';
    $titulo_email = "[Zagatec Contato] {$assunto}";
    $corpo = "Data: " . date('d/m/Y H:i:s') . "\n"
           . "Nome/Apelido: " . ($nome !== '' ? $nome : 'Anônimo') . "\n"
           . "E-mail para retorno: " . ($email !== '' ? $email : 'Não informado') . "\n"
           . "Assunto: {$assunto}\n"
           . "Mensagem:\n{$mensagem}\n"
           . str_repeat('-', 40) . "\n";

    $cabecalhos = "From: noreply@joaoeduardo.site.je\r\n"
                . "Content-Type: text/plain; charset=UTF-8\r\n";

    if ($email !== '') {
      $cabecalhos .= "Reply-To: {$email}\r\n";
    }

    @mail($destino, $titulo_email, $corpo, $cabecalhos);

    $arquivo_log = __DIR__ . '/mensagens_contato.txt';
    @file_put_contents($arquivo_log, $corpo, FILE_APPEND | LOCK_EX);

    $enviado = true;
    $nome = $email = $assunto = $mensagem = '';
  }
}

require_once __DIR__ . '/includes/cabecalho.php';
?>

<section class="pagina-topo">
  <div class="container">
    <h1>Fale com a equipe</h1>
    <p>
      Dúvidas sobre o projeto, parcerias com escolas ou imprensa.
      O atendimento é online, acolhedor e respeita sua privacidade.
    </p>
  </div>
</section>

<section class="secao">
  <div class="container grade-2">

    <!-- Coluna 1: Formulário -->
    <div>
      <h2>Envie uma mensagem</h2>

      <?php if ($enviado): ?>
        <div class="cartao" style="border-color: var(--verde); background: var(--verde-claro);">
          <h3 style="margin-top: 0; color: var(--verde-escuro);">Mensagem registrada com sucesso</h3>
          <p style="color: var(--texto); margin-top: .5rem;">
            Agradecemos o contato. Caso tenha deixado um e-mail para retorno,
            nossa equipe responderá em até <strong>24 horas</strong>.
          </p>
          <p style="margin-top: 1.25rem;">
            <a href="index.php" class="btn btn-primario">Voltar ao início</a>
          </p>
        </div>
      <?php else: ?>

        <form class="formulario" method="post" action="contato.php" novalidate>
          <?php if ($erro !== ''): ?>
            <div class="erro" role="alert"><?= htmlspecialchars($erro) ?></div>
          <?php endif; ?>

          <div class="campo-armadilha" aria-hidden="true">
            <label for="website">Não preencha este campo</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>

          <label for="assunto">Assunto</label>
          <select id="assunto" name="assunto" class="campo" required>
            <option value="" disabled <?= $assunto === '' ? 'selected' : '' ?>>Selecione o motivo do contato...</option>
            <option value="Dúvida sobre o projeto" <?= $assunto === 'Dúvida sobre o projeto' ? 'selected' : '' ?>>Dúvida sobre o projeto</option>
            <option value="Parceria ou palestra em escola" <?= $assunto === 'Parceria ou palestra em escola' ? 'selected' : '' ?>>Parceria ou palestra em escola</option>
            <option value="Apoio institucional / Cooperação" <?= $assunto === 'Apoio institucional / Cooperação' ? 'selected' : '' ?>>Apoio institucional / Cooperação</option>
            <option value="Imprensa ou divulgação" <?= $assunto === 'Imprensa ou divulgação' ? 'selected' : '' ?>>Imprensa ou divulgação</option>
            <option value="Outro assunto" <?= $assunto === 'Outro assunto' ? 'selected' : '' ?>>Outro assunto</option>
          </select>

          <label for="nome">Como prefere ser chamado(a)? <span style="font-weight: 400; color: var(--texto-fraco);">(opcional)</span></label>
          <input type="text" id="nome" name="nome" class="campo" placeholder="Pode usar um apelido ou deixar em branco" value="<?= htmlspecialchars($nome) ?>">

          <label for="email">E-mail para resposta <span style="font-weight: 400; color: var(--texto-fraco);">(opcional)</span></label>
          <p class="dica">Se preferir manter total anonimato, utilize um e-mail secundário.</p>
          <input type="text" id="email" name="email" class="campo" placeholder="voce@exemplo.com" value="<?= htmlspecialchars($email) ?>">

          <label for="mensagem">Mensagem</label>
          <textarea id="mensagem" name="mensagem" class="campo" placeholder="Escreva sua dúvida, sugestão ou proposta de parceria..." required><?= htmlspecialchars($mensagem) ?></textarea>

          <button type="submit" class="btn">Enviar mensagem</button>
        </form>

      <?php endif; ?>
    </div>

    <!-- Coluna 2: Canais diretos e avisos -->
    <div style="display: grid; gap: 1.5rem;">

      <div class="cartao">
        <h3 style="margin-top: 0;">Canais diretos</h3>
        <p style="margin-top: .35rem;">Você também pode falar conosco diretamente pelas nossas redes oficiais:</p>

        <ul style="list-style: none; margin: 1rem 0 1.25rem; padding: 0; display: grid; gap: .85rem; color: var(--texto-suave); font-size: .95rem;">
          <li style="display: flex; align-items: center; gap: .6rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--verde)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span>
              <strong style="color: var(--noite);">E-mail:</strong>
              <a href="mailto:zagatec.osc@gmail.com">zagatec.osc@gmail.com</a>
            </span>
          </li>
          <li style="display: flex; align-items: center; gap: .6rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--verde)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            <span>
              <strong style="color: var(--noite);">Instagram:</strong>
              <a href="https://www.instagram.com/zagatec.osc?cplk=MTcycTR2NnR6aG1mbA%3D%3D" target="_blank" rel="noopener noreferrer">@zagatec.osc</a>
            </span>
          </li>
          <li style="display: flex; align-items: center; gap: .6rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--verde)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>
              <strong style="color: var(--noite);">Atendimento:</strong>
              Resposta em até 24 horas úteis
            </span>
          </li>
        </ul>

        <div style="display: flex; flex-wrap: wrap; gap: .65rem;">
          <a href="https://www.instagram.com/zagatec.osc?cplk=MTcycTR2NnR6aG1mbA%3D%3D" target="_blank" rel="noopener noreferrer" class="btn btn-primario">
            Abrir Instagram
          </a>
          <a href="mailto:zagatec.osc@gmail.com" class="btn btn-secundario">
            Enviar e-mail
          </a>
        </div>
      </div>

      <div class="cartao">
        <span class="icone" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.4 8.7-8 10-4.6-1.3-8-5-8-10V6l8-4z"/></svg>
        </span>
        <h3>Precisa fazer uma denúncia?</h3>
        <p>
          Não envie relatos ou provas por este formulário. Utilize o canal protegido
          para gerar seu protocolo e acompanhar o andamento de forma 100% anônima.
        </p>
        <p style="margin-top: 1.1rem;">
          <a href="https://rede-escudo.onrender.com/" class="btn btn-secundario">Ir para canal de denúncia</a>
        </p>
      </div>

        <div class="cartao">
        <span class="icone" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22        21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </span>
        <h3>Quer atuar como analista freelancer?</h3>
        <p>
          Buscamos profissionais e estudantes de cibersegurança comprometidos com ética e sigilo.
          Para se candidatar, leia e preencha nosso <strong>Termo de Conduta e Confidencialidade</strong>
          e envie-o assinado junto com seu currículo para o nosso e-mail.
        </p>
        <div style="display: flex; flex-wrap: wrap; gap: .65rem; margin-top: 1.1rem;">
          <a href="ver_doc.php?doc=3.pdf" target="_blank" rel="noopener noreferrer" class="btn btn-secundario">
            Abrir termo de conduta
          </a>
          <a href="mailto:zagatec.osc@gmail.com?subject=Candidatura%20-%20Analista%20Freelancer%20Zagatec" class="btn btn-primario">
            Enviar currículo
          </a>
        </div>
      </div>
        
        
      <div class="destaque">
        <h3>Em caso de risco imediato</h3>
        <p style="margin: .5rem 0 1rem; font-size: .95rem;">
          O Zagatec não substitui o atendimento policial de emergência. Se alguém estiver em perigo agora, ligue gratuitamente:
        </p>
        <ul style="list-style: none; margin: 0; padding: 0; display: grid; gap: .5rem; font-size: .95rem;">
          <li><strong style="color: #fff;">190</strong> — Polícia Militar</li>
          <li><strong style="color: #fff;">100</strong> — Disque Direitos Humanos</li>
          <li><strong style="color: #fff;">188</strong> — CVV (apoio emocional 24h)</li>
        </ul>
      </div>

    </div>
  </div>
</section>

<section class="faq">
  <div class="container">
    <h2>Perguntas frequentes</h2>
    <p class="faq-sub">Respostas rápidas sobre o funcionamento do projeto</p>

    <div class="faq-tabela">
      <details>
        <summary>Como levar palestras do Zagatec para minha escola?</summary>
        <p>
          Selecione a opção <strong>"Parceria ou palestra em escola"</strong> no formulário acima ou envie uma mensagem para <strong>zagatec.osc@gmail.com</strong> informando o nome da instituição e a cidade.
        </p>
      </details>

      <details>
        <summary>Preciso me identificar para tirar uma dúvida?</summary>
        <p>
          Não. Os campos de nome e e-mail são opcionais, embora o e-mail seja necessário caso você queira receber uma resposta da nossa equipe.
        </p>
      </details>

      <details>
        <summary>Vocês informam o andamento de denúncias por e-mail ou Instagram?</summary>
        <p>
          Não, para proteger seu anonimato nenhum dado de contato é vinculado às denúncias. Para consultar o progresso, acesse a aba <strong>Acompanhar caso</strong> com seu número de protocolo e código secreto.
        </p>
      </details>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/rodape.php'; ?>