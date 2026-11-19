  </main>

  <!--
    O rodapé usa as variáveis criadas no cabecalho.php ($nome_ong e $menu),
    por isso o cabeçalho precisa ser incluído antes em toda página.
  -->
  <footer class="rodape">
    <div class="container rodape-grade">

      <div>
        <h2><?= htmlspecialchars($nome_ong) ?></h2>
        <p>
          Canal anônimo de denúncia e apoio a vítimas de crimes em grupos online.
          Analisamos cada relato e encaminhamos às autoridades.
        </p>
        <!-- Redes sociais de exemplo: troque o "#" pelos perfis reais quando existirem -->
        <div class="rodape-social">
          <a href="https://www.instagram.com/zagatec.osc?cplk=MTcycTR2NnR6aG1mbA%3D%3D" target="_blank" aria-label="Instagram" rel="noopener noreferrer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn" rel="noopener noreferrer">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
          <a href="mailto:zagatec.osc@gmail.com" aria-label="Enviar e-mail">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </a>
        </div>
      </div>

      <nav aria-label="Rodapé">
        <h2>Navegação</h2>
        <ul>
          <?php foreach ($menu as $item): ?>
            <li><a href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['texto']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div>
        <h2>Em caso de urgência</h2>
        <ul class="rodape-urgencia">
          <li><strong>190</strong> <span>Polícia Militar</span></li>
          <li><strong>100</strong> <span>Disque Direitos Humanos</span></li>
          <li><strong>188</strong> <span>CVV, apoio emocional 24 horas</span></li>
        </ul>
      </div>

      <div>
        <h2>Contato</h2>
        <ul class="rodape-contato">
          <li>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <a href="mailto:zagatec.osc@gmail.com">zagatec.osc@gmail.com</a>
          </li>
          <li>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span>Resposta em até 24 horas</span>
          </li>
          <li>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <span>Atendimento online e anônimo</span>
          </li>
        </ul>
      </div>
 
    </div>

    <div class="rodape-base">
      <div class="container">
        <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($nome_ong) ?>. Projeto criado para o TeenTech de 2026.</p>
        <p>
          <a href="ver_doc.php?doc=2.pdf" target="_blank" rel="noopener noreferrer">Privacidade</a>          &nbsp;&nbsp;
          <a href="contato.php">Contato</a>
        </p>
      </div>
    </div>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>
