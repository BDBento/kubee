<footer class="footer-site">
    <div class="footer-top">
        <div class="container">
            <div class="row align-items-start py-5">
                <!-- Logo -->
                <div class="col-12 col-md-3 mb-4 mb-md-0 text-center text-md-start align-self-center">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-branco-horizontal.png" alt="LevelWork Logo" style="max-width: 145px;">
                </div>
                <!-- Menus -->
                <div class="col-6 col-md-3 mb-3 mb-md-0 empresa-footer">
                    <h6 class="footer-title">Empresa</h6>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_menu_1',
                        'menu_class'     => 'footer-menu list-unstyled',
                        'container'      => false
                    ]);
                    ?>
                </div>
                <div class="col-12 col-md-3 mb-3 mb-md-12 atendimento-footer">
                        <h6 class="footer-title">Atendimento</h6>
                        <ul class="footer-contact list-unstyled">
                            <li class="d-flex gap-2">
                                <span class="fi" aria-hidden="true">
                                    <!-- loja -->
                                    <svg viewBox="0 0 616 512" width="18" height="18" fill="currentColor">
                                        <path d="M602 118.6 537.1 15C531.3 5.7 521 0 510 0H106C95 0 84.7 5.7 78.9 15L14 118.6c-33.5 53.5-3.8 127.9 58.8 136.4 4.5.6 9.1.9 13.7.9 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18.1 20.1 44.3 33.1 73.8 33.1 4.7 0 9.2-.3 13.7-.9 62.8-8.4 92.6-82.8 59-136.4zM529.5 288c-10 0-19.9-1.5-29.5-3.8V384H116v-99.8c-9.6 2.2-19.5 3.8-29.5 3.8-6 0-12.1-.4-18-1.2-5.6-.8-11.1-2.1-16.4-3.6V480c0 17.7 14.3 32 32 32h448c17.7 0 32-14.3 32-32V283.2c-5.4 1.6-10.8 2.9-16.4 3.6-6.1.8-12.1 1.2-18.2 1.2z" />
                                    </svg>
                                </span>
                                <span>Kubee | Plataforma Multi-Channel para Gestão Integrada</span>
                            </li>

                            <li class="d-flex gap-2">
                                <span class="fi" aria-hidden="true">
                                    <!-- whatsapp -->
                                    <svg viewBox="0 0 448 512" width="18" height="18" fill="currentColor">
                                        <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32 101.5 32 1.9 131.6 1.9 254c0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zM224 438.7c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
                                    </svg>
                                </span>
                                <a class="link-underline link-underline-opacity-0"
                                    href="https://wa.me/5567993241931?text=Ol%C3%A1%2C%20tudo%20bem%3F%20Estou%20em%20seu%20site%20e%20gostaria%20de%20entrar%20em%20contato."
                                    target="_blank" rel="nofollow noopener noreferrer">(67) 99324-1931</a>
                            </li>

                            <li class="d-flex gap-2">
                                <span class="fi" aria-hidden="true">
                                    <!-- email -->
                                    <svg viewBox="0 0 512 512" width="18" height="18" fill="currentColor">
                                        <path d="M464 64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm0 48v40.8c-22.4 18.3-58.2 46.7-134.6 106.5-16.8 13.2-50.2 45.1-73.4 44.7-23.2.3-56.6-31.5-73.4-44.7C106.2 199.5 70.4 171.1 48 152.8V112h416zM48 400V214.4c22.9 18.3 55.4 43.9 104.9 82.6 21.9 17.2 60.1 55.2 103.1 55 42.7.2 80.5-37.2 103-54.9 49.6-38.8 82-64.4 105-82.7V400H48z" />
                                    </svg>
                                </span>
                                <a class="link-underline link-underline-opacity-0" href="mailto:contato@kubee.com">contato@kubee.com</a>
                            </li>

                            <li class="d-flex gap-2">
                                <span class="fi" aria-hidden="true">
                                    <!-- clock -->
                                    <svg viewBox="0 0 512 512" width="18" height="18" fill="currentColor">
                                        <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm12 120h-32v128c0 4 2 7.8 5.3 10.2l88 64 19-26-80.3-58.4V128z" />
                                    </svg>
                                </span>
                                <span>De Segunda à Segunda - 24h</span>
                            </li>
                        </ul>
                </div>
                <!-- Newsletter -->
                <div class="col-12 col-md-3">
                    <h6 class="footer-title">Se inscreva</h6>
                    <form class="footer-newsletter" action="#" method="post">
                        <div class="d-flex gap-2">
                            <input type="email" class="form-control" name="newsletter" placeholder="Seu e-mail" required style="background:transparent;color:#fff;">
                            <button type="submit" class="btn btn-newsletter">→</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center py-3">
        <small>@ <?php echo date('Y'); ?> LevelWork. Todos os direitos reservados.</small>
    </div>
    
    <script>
(function(){
  "use strict";

  /* ===== CONFIG ===== */
  const HEADER_SELECTOR = ".site-header, .main-menu, header"; // ajuste conforme seu tema
  const BTN_BG = "#34b092";
  const BTN_FG = "#ffffff";
  const DURATION = 1200; // duração em ms da rolagem suave

  /* ===== HELPERS ===== */
  const qs = (sel, ctx=document) => ctx.querySelector(sel);
  const byId = (id) => document.getElementById(id);

  function getOffsets(){
    const admin = document.body.classList.contains("admin-bar") ? 32 : 0;
    const headerEl = qs(HEADER_SELECTOR);
    const headerH = headerEl ? headerEl.getBoundingClientRect().height : 0;
    return admin + headerH;
  }

  function animateScrollTo(targetY){
    const startY = window.scrollY;
    const diff = targetY - startY;
    let start;

    function easeInOutQuad(t){ return t<0.5 ? 2*t*t : -1+(4-2*t)*t; }

    function step(timestamp){
      if (!start) start = timestamp;
      const time = timestamp - start;
      const percent = Math.min(time / DURATION, 1);
      const eased = easeInOutQuad(percent);
      window.scrollTo(0, startY + diff * eased);
      if (time < DURATION) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  function targetYForId(id){
    const el = byId(id);
    if (!el) return 0;
    const top = el.getBoundingClientRect().top + window.pageYOffset;
    return Math.max(0, top - getOffsets() - 8);
  }

  /* ===== BUTTON ===== */
  const btn = document.createElement("button");
  btn.id = "kubee-back-to-top";
  btn.textContent = "↑";
  Object.assign(btn.style, {
    position:"fixed",right:"16px",bottom:"16px",width:"48px",height:"48px",
    border:"none",borderRadius:"999px",background:BTN_BG,color:BTN_FG,
    fontSize:"20px",lineHeight:"48px",textAlign:"center",cursor:"pointer",
    boxShadow:"0 6px 18px rgba(0,0,0,.2)",zIndex:"9999",
    opacity:"0",visibility:"hidden",transform:"translateY(8px)",
    transition:"opacity .4s, transform .4s, visibility .4s"
  });
  document.body.appendChild(btn);

  const header = qs(HEADER_SELECTOR) || document.body;
  if ("IntersectionObserver" in window && header !== document.body){
    const io = new IntersectionObserver((entries)=>{
      entries.forEach(entry=>{
        if (entry.isIntersecting) btn.style.opacity="0",btn.style.visibility="hidden";
        else btn.style.opacity="1",btn.style.visibility="visible",btn.style.transform="translateY(0)";
      });
    });
    io.observe(header);
  } else {
    window.addEventListener("scroll", ()=>{
      if (window.scrollY > 200){
        btn.style.opacity="1"; btn.style.visibility="visible"; btn.style.transform="translateY(0)";
      } else {
        btn.style.opacity="0"; btn.style.visibility="hidden";
      }
    },{passive:true});
  }

  btn.addEventListener("click", e=>{
    e.preventDefault();
    animateScrollTo(0);
    history.pushState(null,"",location.pathname + location.search);
  });

  /* ===== ANCORAS ===== */
  document.addEventListener("click", e=>{
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;
    const hash = a.getAttribute("href");
    if (hash === "#") return;
    const id = hash.slice(1);
    if (byId(id)){
      e.preventDefault();
      animateScrollTo(targetYForId(id));
      history.pushState(null,"",hash);
    }
  });

  window.addEventListener("load", ()=>{
    if (location.hash && byId(location.hash.slice(1))){
      setTimeout(()=> animateScrollTo(targetYForId(location.hash.slice(1))),0);
    }
  });

})();
</script>


</footer>
<?php wp_footer(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const nav = document.getElementById('mainNav');
  const toggler = document.querySelector('.navbar-toggler');
  if (!nav || !toggler) return;

  // cria/obtém a instância SEM auto-toggle
  const c = bootstrap.Collapse.getOrCreateInstance(nav, { toggle: false });

  // abre/fecha sempre que clicar no ícone
  toggler.addEventListener('click', function () { c.toggle(); });

  // fecha ao clicar em qualquer link do menu
  nav.addEventListener('click', function (e) {
    if (e.target.closest('.nav-link')) c.hide();
  });
});
</script>

</body>

</html>