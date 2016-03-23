<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage bed_and_art
 * @since Bed and Art 1.0
 */

$path_img = esc_url( get_template_directory_uri() ).'/images/';

?>

<footer>
    <div class="primary-footer">
        <div class="container-1024">
            <div class="col-xs-12 col-sm-6 footer-1">
                <p>
                    <span> Cerca<br>il professionista<br>o l'attività<br>di cui hai bisogno</span>
                </p>
            </div>
            <div class="col-xs-12 col-sm-6 footer-2">
                <a class="cv" href="<?php echo home_url() ?>/inserisci-cv">Cerchi lavoro?<br>Lascia il tuo curriculum</a>
                <a class="help migliorare" href="#">Aiutaci a migliorare</a>
                <a class="help assistenza" href="#">Contatta l'assistenza</a>
                <div>
                    <a class="to-info-page" href="#">Note Legali</a>
                    <a class="to-info-page" href="#">Informativa sulla privacy</a>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="secondary-footer">
        <div class="container-1024">
            <div class="col-xs-12">© THEWORKNOTE-2016 | Bullish srl</div>
        </div>
    </div>
</footer>


<?php wp_footer(); ?>

</body>
</html>