<?php
session_start();
$titulo_pagina = 'Conexão Segura — denuncie sem se identificar';
$pagina_atual  = 'inicio';
include 'includes/cabecalho.php';
?>

<section class="hero">
  <div class="container">
    <div>
      <h1>Você não está sozinha(o).</h1>
      <p class="hero-texto">
        Se você ou alguém que você conhece está sendo ameaçado, extorquido ou enganado em grupos online,
        conte o que aconteceu. A denúncia é anônima e leva poucos minutos.
      </p>
      <div class="hero-acoes">
        <a class="btn btn-primario" href="https://rede-escudo.onrender.com/">Fazer uma denúncia</a>
      </div>
      <p class="hero-nota">Não pedimos nome, CPF nem telefone.</p>
    </div>

    <aside class="emergencia" aria-labelledby="titulo-emergencia">
      <h2 id="titulo-emergencia">Está em perigo agora?</h2>
      <p>Esta denúncia não substitui um pedido de socorro. Se for urgente, acione imediatamente:</p>
      <ul>
        <li><span class="numero">190</span> <span class="descricao">Polícia Militar, emergências</span></li>
        <li><span class="numero">100</span> <span class="descricao">Disque Direitos Humanos</span></li>
        <li><span class="numero">188</span> <span class="descricao">CVV, apoio emocional 24 horas</span></li>
      </ul>
    </aside>
  </div>
</section>



<section class="passos" id="como-funciona">
  <div class="container">
    <h2>Como funciona nosso processo</h2>
    <ol>
      <li>
        <div class = "passo-icone">
         <img src="Imagens/Denuncia.png" alt="">
        </div>
        <h3>Conte-nos o que aconteceu</h3>
        <p>Responda perguntas curtas, anexe prints e envie evidências, se tiver. Nosso time tomará conta do caso. Você pode parar a qualquer momento.</p>
      </li>
      <li>
        <div class = "passo-icone">
         <img src="Imagens/Analise.png" alt="">
        </div>
        <h3>Analisamos as provas</h3>
        <p>Nossa equipe confere o relato, organiza as evidências e junta casos que se repetem.</p>
      </li>
      <li>
        <div class = "passo-icone">
         <img src="Imagens/Encaminhamento.png" alt="">
        </div>
        <h3>Encaminhamos às autoridades</h3>
        <p>Quando o caso se confirma, enviamos um relatório técnico à Polícia Federal e ao Ministério Público.</p>
      </li>
    </ol>
  </div>
</section>

<section class="impacto">
  <div class="container">
    <h2>Nosso impacto</h2>
    <ul>

    
      <li>
       <div class = "card">
         <p class="numero">120+</p>
         <h3>Denúncias analisadas e em andamento</h3>
         <p>Cada relato é conferido por um analista antes de qualquer encaminhamento.</p>
       </div>
      </li>
    

    
      <li>
       <div class = "card">
        <p class="numero">45</p>
        <h3>Relatórios enviados às autoridades</h3>
        <p>Dossiês técnicos com as evidências organizadas, enviados à Polícia Federal e ao Ministério Público.</p>
       </div>
      </li>

    
      <li>
        <div class = "card">
        <p class="numero">10+</p>
        <h3>Grupos ilegais mapeados</h3>
        <p>Denúncias repetidas sobre o mesmo grupo, reunidas em um único relatório.</p>
        </div>
      </li>

      <li>
        <div class = "card">
         <p class="numero">24 h</p>
         <h3>Para o primeiro retorno</h3>
         <p>Tempo médio até a equipe responder ao caso, sem exigir identificação.</p>
        </div>
      </li>
 

    </ul>

    <br>
    <br>

    <p class="nota-impacto">Dados ilustrativos, criados para o protótipo.</p>
  </div>
</section>




<section class="faq" id="faq">
  <div class="container">
    <h2>FAQ</h2>
    <p class="faq-sub">Perguntas Frequentemente Feitas</p>

    <div class="faq-tabela">
      <details>
        <summary>Preciso me identificar para denunciar?</summary>
        <p>Não. Não pedimos nome, CPF nem telefone. Você conta o que aconteceu e pode parar a qualquer momento.</p>
      </details>
      <details>
        <summary>O que posso denunciar?</summary>
        <p>Ameaças, extorsão e golpes ou enganos em grupos online, seja com você ou com alguém que você conhece.</p>
      </details>
      <details>
        <summary>Preciso ter provas para enviar a denúncia?</summary>
        <p>Não é obrigatório, mas ajuda. Se tiver prints ou outras evidências, você pode anexá-los durante o relato.</p>
      </details>
      <details>
        <summary>O que acontece depois que eu envio?</summary>
        <p>Nossa equipe confere o relato, organiza as evidências e junta casos que se repetem. Quando o caso se confirma, enviamos um relatório técnico à Polícia Federal e ao Ministério Público.</p>
      </details>
      <details>
        <summary>Em quanto tempo recebo um retorno?</summary>
        <p>O tempo médio até o primeiro retorno da equipe é de 24 horas, sem exigir identificação.</p>
      </details>
      <details>
        <summary>A denúncia substitui um pedido de socorro?</summary>
        <p>Não. Se você está em perigo agora, ligue para o 190 (Polícia Militar). Para apoio emocional, o CVV atende 24 horas pelo 188, e o Disque Direitos Humanos é o 100.</p>
      </details>
    </div>
  </div>
</section>



<section class="cooperacao">
  <div class="container">
    <h2>Canais de cooperação</h2>
    <ul>
      <li>
        <div class="card">
          <img src="Imagens/logo1.png" alt="">
          <h3>Polícia Federal</h3>
          <p>Receberia os relatórios técnicos dos casos confirmados.</p>
        </div>
      </li>
      <li>
        <div class="card">
          <img src="Imagens/logo2.png" alt="">
          <h3>Ministério Público</h3>
          <p>Receberia os dossiês para análise e eventual abertura de procedimento.</p>
        </div>
      </li>
      <li>
        <div class="card">
          <img src="Imagens/logo3.png" alt="">
          <h3>Polícia Civil</h3>
          <p>Receberia os relatórios de casos de competência estadual.</p>
        </div>
      </li>
      <li>
      <div class="card">
          <img src="Imagens/logo4.png" alt="">
          <h3>Instituto Teckids</h3>
          <p>Ajudaria na divulgação da solução através de palestras em escolas e outras instituições de ensino.</p>
        </div>
      </li>
    </ul>

    <p class="nota-impacto">Cooperações previstas para o longo prazo do projeto. Nenhuma parceria foi firmada.</p>
  </div>
</section>



<?php include 'includes/rodape.php'; ?>
