<?php
session_start();
$titulo_pagina = 'Doações — Zagatec';
$pagina_atual  = 'doacoes';
include 'includes/cabecalho.php';

$chave_pix = 'doacoes@zagatec.example'; // troque pela chave real
?>

<section class="pagina-topo">
  <div class="container">
    <h1>Doações</h1>
    <p>Sua contribuição mantém o canal no ar, gratuito e anônimo para todas as vítimas.</p>
  </div>
</section>

<section class="secao">
  <div class="container grade-2">
    <div class="formulario">
      <h2>Doe via Pix</h2>
      <p>Qualquer valor ajuda. Sugestões:</p>
      <div class="valores-doacao">
        <span>R$ 10</span><span>R$ 25</span><span>R$ 50</span><span>R$ 100</span>
      </div>
      <p><strong>Chave Pix (e-mail)</strong></p>
      <div class="pix-chave">
        <span id="chave-pix"><?= htmlspecialchars($chave_pix) ?></span>
        <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('chave-pix').textContent).then(() => { this.textContent = 'Copiado!'; })">Copiar</button>
      </div>
      <p class="nota">Ao doar, o seu nome aparece apenas para o banco. Nunca o ligamos a uma denúncia.</p>
    </div>

    <div class="destaque">
      <h2>Para onde vai o dinheiro</h2>
      <div class="barra-uso">
        <div><p><span>Servidores e segurança</span><span>50%</span></p><div class="barra"><i style="width:50%"></i></div></div>
        <div><p><span>Análise dos casos</span><span>30%</span></p><div class="barra"><i style="width:30%"></i></div></div>
        <div><p><span>Palestras em escolas</span><span>20%</span></p><div class="barra"><i style="width:20%"></i></div></div>
      </div>
    </div>
  </div>
</section>

<section class="secao secao-branca">
  <div class="container">
    <h2>Outras formas de ajudar</h2>
    <ul class="grade-cards">
      <li><div class="cartao"><h3>Compartilhe</h3><p>Divulgue o canal. Alguém perto de você pode estar precisando.</p></div></li>
      <li><div class="cartao"><h3>Leve à sua escola</h3><p>Convide a equipe para uma conversa sobre segurança digital.</p></div></li>
      <li><div class="cartao"><h3>Seja parceiro</h3><p>Empresas e instituições podem apoiar. Escreva para <a href="mailto:contato@zagatec.example">contato@zagatec.example</a>.</p></div></li>
    </ul>
    <p class="nota">Valores e percentuais ilustrativos, criados para o protótipo.</p>
  </div>
</section>

<?php include 'includes/rodape.php'; ?>
