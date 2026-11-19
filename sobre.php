<?php
session_start();
$titulo_pagina = 'Sobre nós — Zagatec';
$pagina_atual  = 'sobre';
include 'includes/cabecalho.php';
?>

<section class="pagina-topo">
  <div class="container">
    <h1>Sobre nós</h1>
    <p>A Zagatec nasceu para dar voz a quem sofre ameaças, extorsão e golpes em grupos online, sem exigir que a vítima se exponha.</p>
  </div>
</section>

<section class="secao">
  <div class="container grade-2">
    <div>
      <h2>Nossa missão</h2>
      <p>Muitas vítimas não denunciam por medo, vergonha ou por não saber a quem recorrer. Criamos um canal simples e anônimo que recebe o relato, organiza as provas e leva o caso até quem pode agir.</p>
      <br>
      <p>Somos um projeto estudantil criado para o TeenTech de 2026, unindo tecnologia e cuidado com as pessoas.</p>
    </div>
    <div class="destaque">
      <p class="numero">100%</p>
      <h3>Anônimo</h3>
      <p>Não pedimos nome, CPF nem telefone. Seu relato chega até nós sem nada que identifique você.</p>
    </div>
  </div>
</section>

<section class="secao secao-branca">
  <div class="container">
    <h2>Nossos valores</h2>
    <ul class="grade-cards">
      <li>
        <div class="cartao">
          <span class="icone" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          </span>
          <h3>Sigilo</h3>
          <p>Protegemos a identidade de quem denuncia em todas as etapas.</p>
        </div>
      </li>
      <li>
        <div class="cartao">
          <span class="icone" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21.2l8.8-8.8a5.5 5.5 0 0 0 0-7.8z"/></svg>
          </span>
          <h3>Acolhimento</h3>
          <p>Escutamos sem julgar. A culpa nunca é da vítima.</p>
        </div>
      </li>
      <li>
        <div class="cartao">
          <span class="icone" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l8 4v6c0 5-3.4 8.7-8 10-4.6-1.3-8-5-8-10V6l8-4z"/></svg>
          </span>
          <h3>Responsabilidade</h3>
          <p>Cada relato é conferido antes de qualquer encaminhamento.</p>
        </div>
      </li>
    </ul>
  </div>
</section>

<section class="secao">
  <div class="container">
    <h2>Os nomes que tornaram esse projeto possível</h2>
    <ul class="grade-cards">
      <li><div class="cartao"><h3>João Eduardo</h3><p>Fundador e e representante da equipe responsável pelo projeto.</p></div></li>
      <li><div class="cartao"><h3>Sanderson Zanini</h3><p>Fundador e integrante da equipe.</p></div></li>
      <li><div class="cartao"><h3>Felipe Holanda</h3><p>Fundador e integrante da equipe.</p></div></li>
      <li><div class="cartao"><h3>Gustavo Silvério</h3><p>Fundador e integrante da equipe.</p></div></li>
      <li><div class="cartao"><h3>Vinicius Torres</h3><p>Fundador e integrante da equipe.</p></div></li>

    </ul>
    <p class="nota">E todos aqueles que apoiaram, apoiam, e irão apoiar nossa idéia.</p>
  </div>
</section>

<?php include 'includes/rodape.php'; ?>
