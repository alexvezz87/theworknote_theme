<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/


/**
 *Template Name: Page Prezzi Gratis
 */

get_header();


?>

<div class="main-container page-prezzi">
    
    <div class="container-descrizione">
        <div class="container-1024">

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>		
                    <?php the_content(); ?>  
                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        <div class="clear"></div> 
    </div>   
    
    <div class="fascia-verde">
        <div class="container-1024">
            <div class="col-xs-12 col-sm-4">
                <h2>La tua attivita' online<br>in pochi click</h2>
            </div>
            <div class="col-xs-12 col-sm-8">
                <div class="container-box-offerta">
                    <div class="box-offerta">
                        <div>
                            <h3>30 giorni</h3>
                            <p>
                                L'utente avrà <strong>30 giorni di prova gratuita</strong> della piattaforma
                            </p>
                        </div>
                    </div>                    
                </div>
                
                <div class="container-box-offerta">
                    <div class="box-offerta">
                        <div>
                            <h3 style="color:#ff0000; font-weight: bold; font-size:20px">ATTENZIONE !!! </h3>
                            <p>
                                Per i primi 500 iscritti, TheWorkNote è GRATIS per un anno!!!
                            </p>
                            <a href="<?php echo home_url() ?>/registrazione/" class="button-link">Iscriviti</a>
                        </div>
                    </div>                    
                </div>
                
                <div class="clear"></div>         
            </div>
            <div class="clear"></div>       
        </div>   
    </div>
    <div class="container-fasce">
        <div class="fascia bianca first">
            <div class="container-1024">
                <div class="col-sm-5 hidden-xs description-row">
                    &nbsp;
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    <h3>Pagine Gialle</h3>
                    <p class="hidden-xs">Offerta di Pagine Gialle</p>
                </div>
                <div class="col-xs-6 col-sm-2 twn">
                    <h3>TheWorkNote</h3>
                    <p class="hidden-xs">Offerta di TheWorkNote<br>costo 90&euro;/anno</p>
                </div>
                <div class="col-xs-3 col-sm-1 fb">
                    <h3>Facebook</h3>
                    <p class="hidden-xs">Offerta di Facebook</p>
                </div>
            </div>
            <div class="clear"></div>     
        </div>

        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Iscrizione SOLO per chi possiede Partita IVA </p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">

                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>

        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Immagine Aziendale</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">

                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Ragione sociale + Indirizzo</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">

                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Telefono</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">

                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Email</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    <p class="values">da 118,80 &euro;/anno</p>
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Foto</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    <p class="values">da 118,80 &euro;/anno</p>
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Parole chiave</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    <p class="values">da 118,80 &euro;/anno</p>
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">
                    
                </div>
                <div class="col-xs-3 col-sm-1 fb croce">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Photogallery</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    <p class="values">da 118,80 &euro;/anno</p>
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Versione tablet e smartphone</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">

                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Ottimizzazione SEO</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">

                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Accesso area privata modificabile in qualunque momento</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    <p class="values">da 118,80 &euro;/anno</p>
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Inserimento news in tempo reale</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg croce">
                    
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Chat istantanea con gli iscritti</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg croce">
                    
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb spunta">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Home page innovativa che visualizza news anche di possibili clienti e fornitori</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg croce">
                    
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb croce">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Matching mirato per contattare o essere contattato da NUOVI clienti</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg croce">
                    
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb croce">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Tutte le news che pubblichi visibili agli altri iscritti senza "filtri"</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg croce">
                    
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb croce">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia grigia">
            <div class="container-1024">
                <div class="col-xs-12 col-sm-5 description-row">
                    <p>Ricerche mirate non solo per nome</p>
                </div>
                <div class="col-xs-3 col-sm-1 pg spunta">
                    
                </div>
                <div class="col-xs-6 col-sm-2 twn spunta">

                </div>
                <div class="col-xs-3 col-sm-1 fb croce">

                </div>
            </div>
            <div class="clear"></div>  
        </div>
        
        <div class="fascia bianca last">
            <div class="container-1024">
                <div class="col-sm-5 hidden-xs description-row">
                    &nbsp;
                </div>
                <div class="col-xs-3 col-sm-1 pg">
                    &nbsp;
                </div>
                <div class="col-xs-6 col-sm-2 twn">
                    <div class="container-button-iscriviti">
                        <a href="<?php echo home_url() ?>/registrazione/" class="button-iscriviti">
                            Iscriviti subito
                        </a>
                    </div>                    
                    
                </div>
                <div class="col-xs-3 col-sm-1 fb">
                   &nbsp;
                </div>
            </div>
            <div class="clear"></div>     
        </div>
        
        <div class="clear"></div>  
    </div>
    <div class="white-main-container" style="padding-top:5px">
        <div class="container-1024" style="text-align: center;">
            <h3 style="font-family: 'Oswald'; font-size:25px; color:red; font-weight: bold">AFFRETTATI !!!</h3>
            <p style="font-size:23px">
               NON PERDERE L'OCCASIONE PER UTILIZZARE THEWORKNOTE GRATIS PER UN ANNO!!
            </p>
        </div>
    </div>
</div>
    


<?php get_footer(); ?>