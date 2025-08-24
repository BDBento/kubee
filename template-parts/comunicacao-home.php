<section class="centralize-comunicacao py-5">
    <div class="container">
        <div class="row align-items-center gy-4">
            <!-- Texto explicativo -->
            <div class="col-lg-6">
                <h2 class="cc-title">Centralize sua comunicação</h2>
                <p class="cc-subtitle">Com mais eficiência,<br>e produtividade para sua empresa</p>
                <p class="cc-desc">Automatize suas vendas e melhore a eficiência do atendimento com nosso software
                    completo para WhatsApp. Ofereça um atendimento rápido, organizado e de alta qualidade aos seus
                    clientes!</p>
                <a href="#" class="btn btn-primary cc-cta">Conheça mais</a>
            </div>
            <!-- Imagem ao lado -->
            <div class="col-lg-6 text-center">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/kubbe-logo-transparente.png"
                    alt="Comunicação centralizada" class="cc-img img-fluid">
            </div>
        </div>
        <!-- Botões ou cards lineares abaixo -->
        <div class="d-flex flex-wrap justify-content-center mt-4 cc-buttons">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="cc-small-card mx-2 my-2">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/robo-chat.png" alt="Bot">
                    <span>Bot de Atendimento</span>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>