<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/
?>

<!-- menu utente loggato -->
        <div class="col-sm-6 hidden-xs menu">
            <a href="<?php echo bp_loggedin_user_domain() ?>">
                <img class="avatar-50" src="<?php echo $img ?>" alt="<?php $current_user->display_name ?>" />
            </a>
            <div class="user-name">                
               <?php 
                    //stampo il nome dell'utente
                    if(strlen($current_user->display_name) > $max_lenght_nome){
                        echo substr($current_user->display_name, 0,$max_lenght_nome).'...'; 
                    }
                    else{
                        echo $current_user->display_name;
                    }

                ?>             
            </div>
           
            
            <div class="icona posta" data-name="posta">
                <?php
                    if($n_posta > 0){
                        echo '<div class="notifica">'.$n_posta.'</div>';                        
                    }
                ?>
                <div class="triangolo"></div>
            </div>            
            <div class="icona notifiche" data-name="notifiche">
               <?php
                    if($n_notifiche > 0){
                        echo '<div class="notifica">'.$n_notifiche.'</div>';                       
                    }
                ?>  
                 <div class="triangolo"></div>
            </div>
            <div class="icona collaborazioni" data-name="collaborazioni">
               <?php
                    if($n_collab > 0){
                        echo '<div class="notifica">'.$n_collab.'</div>';
                    }
                ?>   
                 <div class="triangolo"></div>
            </div>
            <div class="icona cv" data-name="cv">
                 <div class="triangolo"></div>
            </div>
            <div class="icona impostazioni" data-name="impostazioni">
                 <div class="triangolo"></div>
            </div>
           
        </div>
        <div class="submenus hidden-xs col-sm-5">
            <!-- SOTTO MENU PER LA POSTA -->
            <div class="sub-menu" data-name="posta">
                <a href="<?php echo bp_loggedin_user_domain() ?>messages">                   
                    Posta in arrivo
                    <?php
                        if($n_posta > 0){
                            echo '<div class="notifica">'.$n_posta.'</div>';                        
                        }
                    ?>
                </a>
                <a href="<?php echo bp_loggedin_user_domain() ?>messages/sentbox"> Inviati</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>messages/compose"> Scrivi</a>
            </div>
            <!-- SOTTO MENU PER LE NOTIFICHE -->
            <div class="sub-menu" data-name="notifiche">
                <?php
                    //ottengo le notifiche
                    //var_dump($notifiche);
                    $notifiche = bp_notifications_get_notifications_for_user( $current_user->ID, 'string' );
                    if(count($notifiche) > 10){
                        //Se ci sono più di 10 notifiche all'11-esima visualizzo il link per vederle tutte
                        $count = 0;
                        foreach($notifiche as $notifica){
                            if($count < 10){
                                echo $notifica;
                            }
                            else{
                                break;
                            }
                            $count++;
                        }
                        echo '<a href="'.bp_loggedin_user_domain().'notifications">vedi tutte le notifiche</a>';
                    }                   
                    else{
                         if(count($notifiche) == 1 && gettype($notifiche) == 'boolean' ){
                            echo '<a>Non hai notifiche da visualizzare</a>';
                         }
                         else{
                            foreach($notifiche as $notifica){
                                echo $notifica;                            
                            }
                         }
                    }
                
                ?>
            </div>
            <!-- SOTTOMENU PER LE COLLABORAZIONI -->
            <div class="sub-menu" data-name="collaborazioni">
                <a href="<?php echo bp_loggedin_user_domain() ?>friends" >Collaborazioni</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>friends/requests">
                    Richieste in sospeso
                    <?php
                        if($n_collab > 0){
                            echo '<div class="notifica">'.$n_collab.'</div>';                        
                        }
                    ?>
                </a>
            </div>
            <!-- SOTTOMENU PER I CV -->
            <div class="sub-menu" data-name="cv">
                <a href="<?php echo home_url() ?>/scopri-cv">Scopri i curriculum</a>
            </div>
            <!-- SOTTOMENU PER LE IMPOSTAZIONI -->
            <div class="sub-menu" data-name="impostazioni">
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/edit">Modifica profilo</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/public">Visualizza profilo</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/change-avatar">Cambia immagine profilo</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>profile/change-cover-image/">Cambia immagine di copertina</a>
                <a href="<?php echo home_url() ?>/preferenze">Modifca APPERTENZA/PREFERENZE</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>settings">Impostazioni</a>
                <a href="<?php echo bp_loggedin_user_domain() ?>settings/notifications">Notifiche</a>
                <a href="<?php echo wp_logout_url() ?>">Logout</a>
            </div>
        </div>
        
        <!-- fine menu utente loggato -->
        <div class="col-xs-2 hambuger-menu visible-xs">
            <div></div>
        </div>
        
        <!-- menu mobile -->
        <div class="col-xs-8 mobile-menu">
            <div class="col-xs-12" style="padding-bottom:10px;">
                <div class="chiudi"></div>
                <!-- UTENTE -->
                <div class="utente riga">
                    <a href="<?php echo bp_loggedin_user_domain() ?>">
                        <img class="avatar-50" src="<?php echo $img ?>" alt="<?php $current_user->display_name ?>" />
                    </a>
                    <div class="title">
                        <a href="<?php echo bp_loggedin_user_domain() ?>">
                        <?php 
                            //stampo il nome dell'utente
                            if(strlen($current_user->display_name) > $max_lenght_nome){
                                echo substr($current_user->display_name, 0,$max_lenght_nome).'...'; 
                            }
                            else{
                                echo $current_user->display_name;
                            }
                        ?>   
                        </a>
                    </div>
                </div>
                
                <!-- POSTA -->
                <div class="posta riga">
                    <div class="icona">
                        <?php
                            if($n_posta > 0){
                                echo '<div class="notifica">'.$n_posta.'</div>';                        
                            }
                        ?>
                    </div>
                    <div class="title">Posta</div>
                    <div class="sotto-menu">
                        <a href="<?php echo bp_loggedin_user_domain() ?>messages">                   
                            - Posta in arrivo
                            <?php
                                if($n_posta > 0){
                                    echo '<div class="notifica">'.$n_posta.'</div>';                        
                                }
                            ?>
                        </a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>messages/sentbox">- Inviati</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>messages/compose">- Scrivi</a>
                    </div>                    
                </div>
                <!-- NOTIFICHE -->
                <div class="notifiche riga">
                    <a href="<?php echo bp_loggedin_user_domain() ?>notifications" class="icona">
                        <?php
                            if($n_notifiche > 0){
                                echo '<div class="notifica">'.$n_notifiche.'</div>';                       
                            }
                        ?>  
                    </a>
                    <div class="title">
                        <a href="<?php echo bp_loggedin_user_domain() ?>notifications">Notifiche</a>
                    </div>
                </div>
                <!-- COLLABORAZIONI-->
                <div class="collaborazioni riga">
                    <div class="icona">
                        <?php
                            if($n_collab > 0){
                                echo '<div class="notifica">'.$n_collab.'</div>';
                            }
                        ?>   
                    </div>
                    <div class="title">Collaborazioni</div>
                    <div class="sotto-menu">
                        <a href="<?php echo bp_loggedin_user_domain() ?>friends" >- Collaborazioni</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>friends/requests">
                            - Richieste in sospeso
                            <?php
                                if($n_collab > 0){
                                    echo '<div class="notifica">'.$n_collab.'</div>';                        
                                }
                            ?>
                        </a>
                    </div>         
                </div>
                <!-- CURRICULUM -->
                <div class="cv riga">
                    <a href="<?php echo home_url() ?>/scopri-cv" class="icona"></a>
                    <div class="title">
                        <a href="<?php echo home_url() ?>/scopri-cv">Curriculum</a>
                    </div>
                </div>
                <!-- IMPOSTAZIONI -->
                <div class="impostazioni riga">
                    <div class="icona"></div>
                    <div class="title">Impostazioni</div>
                    <div class="sotto-menu">
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/edit">- Modifica profilo</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/public">- Visualizza profilo</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/change-avatar">- Cambia immagine</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>profile/change-cover-image/">- Cambia copertina</a>
                        <a href="<?php echo home_url() ?>/preferenze">- Modifca APPERTENZA/PREFERENZE</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>settings">- Impostazioni</a>
                        <a href="<?php echo bp_loggedin_user_domain() ?>settings/notifications">- Notifiche</a>
                        <a href="<?php echo wp_logout_url() ?>">- Logout</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- end menu mobile -->