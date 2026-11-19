/* ==========================================================================
   Conexão Segura — comportamento do site
   Não usa scripts inline, então funciona com a política script-src 'self'.
   Duas partes: (1) saída rápida, em todas as páginas; (2) formulário em etapas.
   ========================================================================== */

(function () {
  'use strict';

  /* ---------- 1. Saída rápida ---------- */

  const DESTINO_SAIDA = 'https://www.google.com';

  function sairRapido() {
    // replace() troca a página sem deixá-la no histórico: o botão "voltar" não revela o site.
    window.location.replace(DESTINO_SAIDA);
  }

  const botaoSaida = document.getElementById('saida-rapida');
  if (botaoSaida) {
    botaoSaida.addEventListener('click', sairRapido);
  }

  // Atalho de teclado: Esc duas vezes em menos de 0,8 segundo
  let ultimoEsc = 0;
  document.addEventListener('keydown', function (evento) {
    if (evento.key !== 'Escape') return;
    const agora = Date.now();
    if (agora - ultimoEsc < 800) sairRapido();
    ultimoEsc = agora;
  });


  /* ---------- 2. Formulário de denúncia em etapas ---------- */

  const form = document.getElementById('form-denuncia');
  if (!form) return; // outras páginas não têm o formulário

  const MAX_ARQUIVOS = 5;
  const MAX_MB = 5;

  const etapas = Array.from(form.querySelectorAll('.etapa'));
  const segmentos = document.querySelectorAll('.progresso-seg');
  const rotulo = document.getElementById('rotulo-etapa');
  const campoProvas = document.getElementById('provas');
  const listaProvas = document.getElementById('lista-provas');
  const resumo = document.getElementById('resumo');
  const reduzMovimento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  let atual = 0;

  function mostrarEtapa(indice, aoCarregar) {
    atual = indice;

    etapas.forEach(function (etapa, i) { etapa.hidden = i !== indice; });
    segmentos.forEach(function (seg, i) { seg.classList.toggle('ativo', i <= indice); });
    rotulo.textContent = 'Etapa ' + (indice + 1) + ' de ' + etapas.length;

    if (indice === etapas.length - 1) montarResumo();

    if (aoCarregar) return; // na primeira exibição não mexe no foco nem na rolagem

    // Leva o foco ao título da etapa: quem usa leitor de tela ouve a mudança
    etapas[indice].querySelector('h2').focus();
    window.scrollTo({ top: 0, behavior: reduzMovimento ? 'auto' : 'smooth' });
  }

  // Valida só os campos da etapa visível; reportValidity() mostra o aviso do navegador
  function etapaValida(indice) {
    const campos = etapas[indice].querySelectorAll('input, select, textarea');
    for (const campo of campos) {
      if (!campo.checkValidity()) {
        campo.reportValidity();
        return false;
      }
    }
    return true;
  }

  function avancar() {
    if (etapaValida(atual) && atual < etapas.length - 1) mostrarEtapa(atual + 1);
  }

  // Os botões "Continuar" e "Voltar" têm data-acao no HTML
  form.addEventListener('click', function (evento) {
    const botao = evento.target.closest('[data-acao]');
    if (!botao) return;
    if (botao.dataset.acao === 'continuar') avancar();
    if (botao.dataset.acao === 'voltar' && atual > 0) mostrarEtapa(atual - 1);
  });

  // Enter dentro de um campo tentaria enviar o formulário inteiro antes da hora.
  // Fora da última etapa, vira "Continuar".
  form.addEventListener('submit', function (evento) {
    if (atual < etapas.length - 1) {
      evento.preventDefault();
      avancar();
      return;
    }
    const enviar = form.querySelector('button[type="submit"]');
    enviar.disabled = true;           // evita envio duplo
    enviar.textContent = 'Enviando...';
  });

  /* Provas: confere quantidade e tamanho antes de enviar */
  campoProvas.addEventListener('change', function () {
    const arquivos = Array.from(campoProvas.files);
    let erro = '';

    if (arquivos.length > MAX_ARQUIVOS) {
      erro = 'Envie no máximo ' + MAX_ARQUIVOS + ' arquivos.';
    } else if (arquivos.some(function (a) { return a.size > MAX_MB * 1024 * 1024; })) {
      erro = 'Cada arquivo deve ter no máximo ' + MAX_MB + ' MB.';
    }

    campoProvas.setCustomValidity(erro); // bloqueia o avanço enquanto houver erro
    listaProvas.replaceChildren();
    arquivos.forEach(function (arquivo) {
      const item = document.createElement('li');
      item.textContent = arquivo.name; // textContent nunca interpreta HTML
      listaProvas.appendChild(item);
    });
    if (erro) campoProvas.reportValidity();
  });

  /* Revisão: monta o resumo com textContent (seguro contra injeção de HTML) */
  function valor(nome) {
    const campo = form.elements[nome];
    return campo && campo.value ? campo.value.trim() : '';
  }

  function formatarData(iso) {
    if (!iso) return '';
    const partes = iso.split('-'); // AAAA-MM-DD
    return partes[2] + '/' + partes[1] + '/' + partes[0];
  }

  function montarResumo() {
    const tipo = form.querySelector('input[name="tipo"]:checked');
    const plataforma = form.elements['plataforma'];
    const qtd = campoProvas.files.length;

    const linhas = [
      ['Situação', tipo ? tipo.dataset.rotulo : ''],
      ['Plataforma', plataforma.value ? plataforma.options[plataforma.selectedIndex].text : ''],
      ['Link do servidor, grupo ou perfil', valor('link_servidor')],
      ['Quem está agindo', valor('usuario_denunciado')],
      ['Início aproximado', formatarData(valor('data_inicio'))],
      ['Relato', valor('relato')],
      ['Imagens anexadas', qtd ? qtd + (qtd === 1 ? ' arquivo' : ' arquivos') : '']
    ];

    resumo.replaceChildren();
    linhas.forEach(function (linha) {
      const bloco = document.createElement('div');
      const termo = document.createElement('dt');
      const descricao = document.createElement('dd');
      termo.textContent = linha[0];
      descricao.textContent = linha[1] || 'Não informado';
      bloco.append(termo, descricao);
      resumo.appendChild(bloco);
    });
  }

  // Começa na etapa 1. Sem JavaScript, as quatro etapas ficam visíveis e o formulário ainda envia.
  mostrarEtapa(0, true);
})();
