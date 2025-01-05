<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    
    <?php wp_head(); ?>
</head>
<body>

<header>
    <?php
    $header_sections = array(
        array(
            'class' => 'header-mobile',
            'menu_icon' => 'closemenu_icon.png',
        ),
        array(
            'class' => 'header-desktop',
            'menu_icon' => 'menu_icon.png',
        )
    );

    // Parcourir les sections d'en-tête et générer le code HTML correspondant
    foreach ($header_sections as $section) {
    ?>
        <!-- Début de la section d'en-tête avec la classe <?php echo $section['class']; ?> -->
        <section class="header <?php echo $section['class']; ?>">
            <div>
                <img class="header__heading" src="<?php echo get_template_directory_uri(); ?>/assets/images/site_logo.png" alt="Logo Nathalie Mota" onclick="window.location.href='<?php echo site_url() ?>'"/>
                <img class="header__btn-menu" src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $section['menu_icon']; ?>" alt="Icône de menu" />
            </div>
            <nav class="header__nav <?php echo $section['class']; ?>__nav">
                <?php
                // Vérifier si le menu de navigation principal existe
                if (has_nav_menu('primary_menu')) {
                    wp_nav_menu(array('theme_location' => 'primary_menu'));
                }
                ?>
                <ul>
                    <!-- Élément du menu pour la modal de contact -->
                    <li class="btn-modale">Contact</li>
                </ul>
            </nav>
        </section>
        <!-- Fin de la section d'en-tête avec la classe <?php echo $section['class']; ?> -->
    <?php
    }
    ?>
</header>


</body>
</html>




</body>
</html>
