<?php

add_action('after_setup_theme', function() {
    add_theme_support('title-tag');
    add_theme_support('menus');
    register_nav_menus(array(
        'primary_menu' => __('Primary Menu'),
	    'footer_menu'  => __('Footer Menu'),
    ));
});

function theme_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_scripts() {
    wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '', true);
}
add_action('wp_footer', 'theme_scripts');

add_theme_support( 'post-thumbnails' );

function afficherTaxonomies($nomTaxonomie,$categ) {
    if($terms = get_terms(array(
        'taxonomy' => $nomTaxonomie,
        'orderby' => 'name'
    ))) {
        foreach ( $terms as $term ) {
            if($categ != $term->name){
            echo '<option class="js-filter-item" value="' . $term->slug . '">' . $term->name . '</option>';
            } else {
                echo '<option class="js-filter-item" value="' . $term->slug . '" selected>' . $term->name . '</option>';
            }
        }
    }
}



function filter() {
    $requeteAjax = new WP_Query(array(
        'post_type' => 'photo',
        'orderby' => 'date',
        'order' => $_POST['orderDirection'],
        'posts_per_page' => 8,
        'paged' => $_POST['page'],
        'tax_query' =>
            array(
                'relation' => 'AND',
                $_POST['categorieSelection'] != "all" ?
                    array(
                        'taxonomy' => $_POST['categorieTaxonomie'],
                        'field' => 'slug',
                        'terms' => $_POST['categorieSelection'],
                    )
                : '',
                $_POST['formatSelection'] != "all" ?
                    array(
                        'taxonomy' => $_POST['formatTaxonomie'],
                        'field' => 'slug',
                        'terms' => $_POST['formatSelection'],
                    )
                : '',
            )
        )
    );
    afficherImages($requeteAjax, true);
}
add_action('wp_ajax_nopriv_filter', 'filter');
add_action('wp_ajax_filter', 'filter');



function afficherImages($galerie, $exit) {
    if($galerie->have_posts()) {
        while ($galerie->have_posts()) { ?>
        <?php $galerie->the_post(); ?>
            <div class="colonne">
                <div class="rangee">
                    <img class="img-medium" src="<?php echo the_post_thumbnail_url(); ?>" />
                    <div>
                        <div class="img-hover" >
                            <img class="btn-plein-ecran" src="<?php echo get_template_directory_uri(); ?>/assets/images/fullscreen.png" alt="Icône de plein écran" />
                            <a href="<?php echo get_post_permalink(); ?>">
                                <img class="btn-oeil" src="<?php echo get_template_directory_uri(); ?>/assets/images/eye_icon.png" alt="Icône en fome d'oeil" />
                            </a>
                            <div class="img-infos">
                                <p><?php the_title(); ?></p>
                                <p><?php echo strip_tags(get_the_term_list($galerie->ID, 'categories')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <?php
        }
    }
    else {
        echo "";
    }
    wp_reset_postdata();
    if ($exit) {
        exit(); 
    }
}









