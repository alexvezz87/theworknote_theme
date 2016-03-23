<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myWidget
 *
 * @author Alex
 */
class MyWidget extends WP_Widget {
    //put your code here
    
        public function MyWidget() {
		// Instantiate the parent object
		
		parent::__construct(
			'show_base_value', // Base ID
			__( 'Visualizza info base', 'Widget che visualizza informazioni base dell\'azienda' ), // Name
			array( 'description' => __( 'Visualizza info base', 'Una bella descrizione del mio piccolo widget' ), ) // Args
		);
	
	}

	public function widget( $args, $instance ) {
            // Widget output            
            //ottengo il nome utente dall'url corrente che ha la sintassi .../members/nome_utente           
            
            $id_user = getIdMemeber(curPageURL()); 
            $upload_dir = wp_upload_dir();
            $current_user = wp_get_current_user();
            if($id_user != null){
                //prendo le immagini
                $result_get_images = getGallery($id_user);
                $max_image_show = 6;
                //ottengo l'indirizzo
                $result_get_address = getAddress($id_user);
                
                
        ?>
            <!-- Prima colonna -->
            <div class="col-xs-12 col-sm-6 col-sx">
                
                <!-- Descrizione negozio -->
                <div class="descrizione-negozio box">
                    <h3>DESCRIZIONE</h3>
                    <p><?php echo getField(bp_displayed_user_id(), 'Descrizione'); ?></p>
                </div>
                <div class="clear"></div>
                <!-- fine Descrizione negozio -->
                
                <!-- Mappa-->
                <div id="mappa" class="box">
        <?php           
                    if(count($result_get_address) > 0){
                        
        ?>
                        <h3>Mappa</h3>
        <?php
                        echo '<iframe
                                width="100%"
                                height="220"
                                frameborder="0" style="border:0"
                                src="https://www.google.com/maps/embed/v1/search?key=AIzaSyCYM4sS-KejNPeTGKqu4DnvtOwrDlYIiUk';
                        echo '&q=';
                        for($i=0; $i < count($result_get_address); $i++){
                            echo urlencode($result_get_address[$i]->value);
                            if($i < count($result_get_address)-1)
                                echo '+';
                        }                               
                        echo '"></iframe>';
                        }
        ?>
                    
                </div>
                <div class="clear"></div>
                <!-- fine Mappa-->
                
                <!-- Orari di apertura -->
                <div id="orari-apertura" class="box">
                    <div class="ico-orario"></div>
        <?php        
                if(getField(bp_displayed_user_id(), 'Lunedì') != null ||  
                        getField(bp_displayed_user_id(), 'Martedì') != null ||
                        getField(bp_displayed_user_id(), 'Mercoledì') != null ||
                        getField(bp_displayed_user_id(), 'Giovedì') != null ||
                        getField(bp_displayed_user_id(), 'Venerdì') != null ||
                        getField(bp_displayed_user_id(), 'Sabato') != null ||
                        getField(bp_displayed_user_id(), 'Domenica') != null){          
        ?>
                  
                  <table>
                     <?php if(getField(bp_displayed_user_id(), 'Lunedì') != null) { ?><tr><td>Lunedì</td><td><?php echo getField(bp_displayed_user_id(), 'Lunedì') ?></td></tr><?php } ?>
                     <?php if(getField(bp_displayed_user_id(), 'Martedì') != null) { ?><tr><td>Martedì</td><td><?php echo getField(bp_displayed_user_id(), 'Martedì') ?></td></tr><?php } ?>
                     <?php if(getField(bp_displayed_user_id(), 'Mercoledì') != null) { ?><tr><td>Mercoledì</td><td><?php echo getField(bp_displayed_user_id(), 'Mercoledì') ?></td></tr><?php } ?>
                     <?php if(getField(bp_displayed_user_id(), 'Giovedì') != null) { ?><tr><td>Giovedì</td><td><?php echo getField(bp_displayed_user_id(), 'Giovedì') ?></td></tr><?php } ?>
                     <?php if(getField(bp_displayed_user_id(), 'Venerdì') != null) { ?><tr><td>Venerdì</td><td><?php echo getField(bp_displayed_user_id(), 'Venerdì') ?></td></tr><?php } ?>
                     <?php if(getField(bp_displayed_user_id(), 'Sabato') != null) { ?><tr><td>Sabato</td><td><?php echo getField(bp_displayed_user_id(), 'Sabato') ?></td></tr><?php } ?>
                     <?php if(getField(bp_displayed_user_id(), 'Domenica') != null) { ?><tr><td>Domenica</td><td><?php echo getField(bp_displayed_user_id(), 'Domenica') ?></td></tr><?php } ?>
                  </table>
        <?php   
                }
                else{
                    if(bp_displayed_user_id() == get_current_user_id()){
                        ?>
                          <h2>Orari di apertura</h2>
                        <?php
                    }
                }

                if(bp_displayed_user_id() == get_current_user_id()){
                    printModifyOrariApertura($current_user->ID, curPageURL());
                }          
        ?>
                </div>                
                <!-- fine Orari di apertura -->                
            </div>
            <!-- fine Prima colonna -->
            
            <!-- Seconda colonna -->
            <div class="col-xs-12 col-sm-6">
                <!-- Galleria immagini -->
                <div class="foto box">
                <h3>FOTO</h3>
                <ul id="info_gallery">
        <?php     
                    
                if(count($result_get_images) > 0){
                    //faccio un check sul contenuto delle immagini
                    $count_vuote = 0;
                    for($i=0; $i < count($result_get_images); $i++){
                        if($result_get_images[$i]->value == ''){
                            $count_vuote++;
                        }
                    }
                    if(count($result_get_images) != $count_vuote){
                        for($i=0; $i < $max_image_show; $i++){
                            if($result_get_images[$i]->value != ''){
        ?>                    
                                <li class="gallery-image" data-num="<?php echo ($i+1) ?>" style="background-image:url('<?php echo$upload_dir['baseurl'].$result_get_images[$i]->value ?>')"></li>
        <?php
                            }
                        }
                    }
                }   
        ?>          
                </ul>
                <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <!-- fine Galleria Immagini -->
                
                <!-- Collaboratori -->
                <div class="box">
                <h3>COLLABORATORI</h3>
                <ul class="collaboratori ">
        <?php
                $args = 'user_id='.$id_user.'&per_page=8&populate_extras=0'; 
                if(bp_has_members( $args )){
                ?>
                    <?php while ( bp_members() ) : bp_the_member(); ?>

                        <li <?php bp_member_class(); ?>>
                            <div class="item-avatar">
                                    <a title="<?php bp_member_name(); ?>" href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar('type=full&height=80&width=80'); ?></a>
                            </div> 
                        </li>

                <?php endwhile; } ?>                
                   
                </ul>
                </div>
                <!-- fine Collaboratori -->
                
            </div>
            <div class="clear"></div>
            <!-- fine Seconda colonna -->
            
            <div id="container-slider-foto">
                <div class="container-1024">
                    <div class="close-window"><span></span></div>
                    <div class="prec"><span></span></div>
                    <?php 
                    if(count($result_get_images) > 0){
                        //faccio un check sul contenuto delle immagini
                        $count_vuote = 0;
                        for($i=0; $i < count($result_get_images); $i++){
                            if($result_get_images[$i]->value == ''){
                                $count_vuote++;
                            }
                        }                    
                    ?>                    
                    <ul class="slider-foto" data-slide="<?php echo (count($result_get_images) - $count_vuote) ?>">
                        <?php            
                                
                                    
                                    if(count($result_get_images) != $count_vuote){
                                        for($i=0; $i < count($result_get_images); $i++){
                                            if($result_get_images[$i]->value != ''){
                        ?>                    
                                                <li class="gallery-image" data-num="<?php echo ($i+1) ?>" style="background-image:url('<?php echo$upload_dir['baseurl'].$result_get_images[$i]->value ?>')"></li>
                        <?php
                                            }
                                        }
                                    }
                                   
                        ?>          
                    </ul> 
                    
                    <?php } ?>
                    <div class="succ"><span></span></div>
                </div>
            </div>
            
        <?php

                 
               //  printProfileUserButton(curPageURL());
               //printModifyImagesButton($current_user->ID, curPageURL());       
                
                //print_r($result_get_images);
                
        
          //ORARI DI APERTURA
          
          //FINE ORARI DI APERTURA
           
            }
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
        }
        
        
        
}


