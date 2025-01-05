<div class="modale" id="modale-container">
    <!-- Conteneur de la modale -->
    <div class="modale__content">
        <!-- Contenu de la modale -->
        <button class="modale__content__close btn-close" id="close-modale" type="button">
            <!-- Bouton de fermeture de la modale -->
            <img src="<?= get_template_directory_uri(); ?>/assets/images/close_icon.png" alt="Croix de fermeture" />
        </button>
        <div class="modale__content__header">
            <!-- En-tête de la modale -->
            <?php for ($i = 0; $i < 2; $i++) : ?>
                <!-- Boucle pour créer 2 lignes dans l'en-tête -->
                <div class="modale__content__header__line">
                    <!-- Ligne de l'en-tête de la modale -->
                    <?php for ($j = 0; $j < 5; $j++) : ?>
                        <!-- Boucle pour ajouter 5 images de contact dans chaque ligne -->
                        <img src="<?= get_template_directory_uri(); ?>/assets/images/contact_texte.png" alt="Contact" />
                    <?php endfor; ?>
                </div>
            <?php endfor; ?>
        </div>
        <div class="modale__content__form">
            <!-- Formulaire de la modale -->
            <?= apply_shortcodes('[contact-form-7 id="22" title="Contact form 1"]'); ?> <!-- Utilisation du shortcode Cf7 pour afficher un formulaire de contact -->
        </div>
    </div>
</div>
