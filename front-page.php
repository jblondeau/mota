<?php get_header(); ?>

<section class="hero">
    <h1>Photographe event</h1>
    <?php 
        $categ = null;
        if(isset($_GET['categorie'])){
            $categ = $_GET['categorie'];
        }
        // Requête pour récupérer une image aléatoire du type de contenu 'photos' avec la taxonomie 'format' définie en 'paysage'
        $random_image = new WP_Query(array (
            'post_type' => 'photo',
            'tax_query' => array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => 'paysage',
                ),
            ),
            'orderby' => 'rand',
            'posts_per_page' => '1'
        ));

        // Afficher l'image aléatoire si disponible
        if ($random_image->have_posts()) {
            while ($random_image->have_posts()) {
                $random_image->the_post();
                echo '<img class="hero__background" src="';
                echo the_post_thumbnail_url();
                echo '" />';
            }
        }
        wp_reset_postdata();
    ?> 
</section>

<section class="galerie bloc-page">
    <div class="filtres colonnes">
        <div class="filtres__taxonomie colonnes colonne">
            <!-- Formulaire pour filtrer par la taxonomie 'categories' -->
            <form id="categories" class="js-filter-form filtres__taxonomie_categories filtre colonne">
                <label for="select-categorie">Catégories</label>
                <select id="select-categorie" name="categorie">
                    <!-- <option value="all" hidden></option> -->
                    <option value="all">Toutes les catégories</option>
                    <?php afficherTaxonomies('categories',$categ); // Appel de la fonction pour afficher les termes de taxonomie ?>
                </select>
            </form>
            <!-- Formulaire pour filtrer par la taxonomie 'format' -->
            <form id="format" class="js-filter-form filtres_taxonomie__formats filtre colonne">
                <label for="select-format">Formats</label>
                <select id="select-format" name="format">
                    <<!-- option value="all" hidden></option> -->
                    <option value="all">Tous les formats</option>
                    <?php afficherTaxonomies('format',$categ); // Appel de la fonction pour afficher les termes de taxonomie ?>
                </select>
            </form>
        </div>
        <div class="filtres__tri colonnes colonne">
            <div class="colonne">
            
            </div>
            <!-- Formulaire pour trier par ordre -->
            <form id="ordre" class="js-filter-form filtres_taxonomie__formats filtre colonne">
                <label for="select-ordre">Trier par</label>
                <select id="select-ordre" name="ordre">
                    <option class="js-ordre-item" value="DESC">Nouveautés</option>
                    <option class="js-ordre-item" value="ASC">Les plus anciens</option>
                </select>
            </form>
        </div>
    </div>
    <div class="galerie__photos colonnes">
        <?php 
            // Requête pour récupérer des images du type de contenu 'photos', triées par date
            $galerie = new WP_Query(array (
                'post_type' => 'photo',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => 8,
                'paged' => 1)
            );

            // Appel de la fonction pour afficher les images en utilisant la fonction 'afficherImages'
            afficherImages($galerie, false,);
        ?>
    </div>
    <div class="galerie__btn">
        <input type="button" value="Charger plus">
        <img id="btn-charger-plus" src="<?php echo get_template_directory_uri(); ?>/assets/images/camera_icon.png" alt="Icône appareil photo" />
    </div>
</section>

<?php get_footer(); ?>
