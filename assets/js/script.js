(function($) {
  'use strict';

  // Ajoute la classe 'bouton' aux éléments ayant la classe '.wpcf7-submit'
  $('.wpcf7-submit').addClass('bouton');

  // Durée de la transition de la popup en millisecondes
  var dureeTransitionPopup = 500;

  // Sélectionne les éléments de la modale et des boutons de fermeture
  var modale = $('#modale-container');
  var btnFermetureModale = $('#close-modale');
  var btnFermetureLightbox = $('#close-lightbox');

  // Lorsqu'on clique sur un bouton avec la classe '.btn-modale'
  $('.btn-modale').click(function() {
      transitionPopup($('.modale'), 1); // Affiche la modale avec effet de transition
  });

  // Lorsqu'on clique sur le bouton de fermeture de la modale
  btnFermetureModale.click(function() {
      transitionPopup($('.modale'), 0); // Ferme la modale avec effet de transition
  });

  // Lorsqu'on clique en dehors de la modale, ferme celle-ci
  $(window).click(function(event) {
      if (event.target === modale[0]) {
          transitionPopup($('.modale'), 0);
      }
  });

  // Lorsqu'on clique sur un bouton avec la classe '.btn-plein-ecran'
  $(document).on('click', '.btn-plein-ecran', function() {
      // Affiche une image agrandie dans une lightbox
      var image = $(this).parent().parent().prev();
      var urlImage = image.attr('src');
      var creerImage = `<img src="${urlImage}" alt="Image agrandie">`;
      $('.lightbox__image').html(creerImage);
      transitionPopup($('.lightbox'), 1); // Affiche la lightbox avec effet de transition
  });

  // Lorsqu'on clique sur le bouton de fermeture de la lightbox
  btnFermetureLightbox.click(function() {
      transitionPopup($('.lightbox'), 0); // Ferme la lightbox avec effet de transition
  });

  // Fonction pour effectuer une transition d'affichage avec une opacité donnée
  function transitionPopup(element, opacity) {
      $(element).css('display', opacity === 1 ? 'flex' : 'none');
      $(element).animate({ opacity: opacity }, dureeTransitionPopup);
  }

  // Calcul de la hauteur du menu mobile et initialisation des variables
  let menuMobileOrigine = $('.header-mobile').height() * -1;
  let menuOuvert = -1;
  $('.header-mobile').css('margin-top', menuMobileOrigine);

  // Lorsqu'on clique sur le bouton du menu mobile
  $('.header__btn-menu').click(function() {
      if (menuOuvert === -1) {
          $('.header-mobile').css('opacity', '1');
          effetMenu(0, 0); // Affiche le menu mobile avec effet de transition
      } else {
          effetMenu(1, menuMobileOrigine); // Masque le menu mobile avec effet de transition
          setTimeout(function() {
              $('.header-mobile').css('opacity', '0');
          }, dureeTransitionPopup);
      }
  });

  // Fonction pour appliquer l'effet de transition au menu mobile
  function effetMenu(opacite, position) {
      setTimeout(function() {
          $('.header-desktop').css('opacity', opacite);
      }, dureeTransitionPopup / 2);
      $('.header-mobile').animate({ 'margin-top': position }, dureeTransitionPopup);
      menuOuvert *= -1;
  }
$('.interaction-photo__btn').click(function() {
    $('.wpcf7-text.wpcf7-tel.wpcf7-validates-as-tel').val($('#reference-photo').text());
});


  // Fonction pour gérer la navigation entre les images
  function navigationPhotos(fleche, image) {
      fleche.hover(
          function() {
              image.css('opacity', '1');
          }, function() {
              image.css('opacity', '0');
          }
      );
  }

  // Applique la fonction de navigation aux flèches gauche et droite
  navigationPhotos($('.fleche-gauche'), $('.previous-image'));
  navigationPhotos($('.fleche-droite'), $('.next-image'));

  // Gestion de la pagination des images
  let pageActuelle = 1;
  $('#btn-charger-plus').on('click', function() {
      pageActuelle++;
      ajaxRequest(true); // Effectue une requête AJAX pour charger plus d'images
  });

  // Gestion du formulaire de filtrage
  $(document).on('change', '.js-filter-form', function(e) {
      e.preventDefault();
      pageActuelle = 1;
      ajaxRequest(false); // Effectue une requête AJAX pour filtrer les images
  });

  // Fonction pour effectuer une requête AJAX et mettre à jour la galerie de photos
  function ajaxRequest(chargerPlus) {
      var categorie = $('#categories');
      var categorieTaxonomie = categorie.attr('id');
      var categorieSelection = categorie.find('option:selected').val();
      var format = $('#format');
      var formatTaxonomie = format.attr('id');
      var formatSelection = format.find('option:selected').val();
      var ordre = $('#ordre').find('option:selected').val();
      $.ajax({
          type: 'POST',
          url: 'wp-admin/admin-ajax.php',
          dataType: 'html',
          data: {
              action: 'filter',
              categorieTaxonomie: categorieTaxonomie,
              categorieSelection: categorieSelection,
              formatTaxonomie: formatTaxonomie,
              formatSelection: formatSelection,
              orderDirection: ordre,
              page: pageActuelle
          },
          success: function(resultat) {
              if (chargerPlus) {
                  $('.galerie__photos').append(resultat);
              } else {
                  $('.galerie__photos').html(resultat);
              }
          },
          error: function(result) {
              console.warn(result);
          }
      });
  }

})(jQuery);
