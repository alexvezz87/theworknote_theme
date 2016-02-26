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
                 echo '<div id="info_gallery">';
                 printProfileUserButton(curPageURL());
                 printModifyImagesButton($current_user->ID, curPageURL());       
                $result_get_images = getGallery($id_user);
                //print_r($result_get_images);
                
                if(count($result_get_images) > 0){   
                    
                   //faccio un check sul contenuto delle immagini
                    $count_vuote = 0;
                    for($i=0; $i < count($result_get_images); $i++){
                        if($result_get_images[$i]->value == ''){
                            $count_vuote++;
                        }
                        
                    }
                    
                    //echo '<br>totali: '.count($result_get_images).'<br>vuote: '.$count_vuote.'<br>';
                    if(count($result_get_images) != $count_vuote){
                
                //NUOVO SLIDER
                //inlcudo i js
                echo '<script type="text/javascript" src="'.get_template_directory_uri().'-child/js/jssor.slider.mini.js"></script>';      
                
                //scrivo jquery per la configurazione
                echo '<script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 600,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                $SlideWidth: 200,                                   //[Optional] Width of every slide in pixels, default value is width of \'slides\' container
                $SlideHeight: 150,                                //[Optional] Height of every slide in pixels, default value is height of \'slides\' container
                $SlideSpacing: 3, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 4,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                              //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don\'t want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 960));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
            
            
            $(\'.container-images img\').css(\'cursor\', \'pointer\');
            
            $(\'html\').click(function() {
                //Hide the menus if visible
                $(\'#containerImgGrande\').fadeOut(function(){
                     $(\'#containerImgGrande\').remove();
                });
               
            });            
            $(\'.container-images img\').click(function(event){
                event.stopPropagation();
                //creo l\'immagine grande
                $(\'#containerImgGrande\').fadeOut();
                $(\'#containerImgGrande\').remove();
                var imgGrande = \'<div id="containerImgGrande"><div class="imgGrande"><img src="\'+$(this).attr(\'src\')+\'"></div></div>\';
                $(imgGrande).appendTo(\'body\');      
                $(\'#containerImgGrande\').css(\'height\', $(\'html\').height());
                $(\'#containerImgGrande\').fadeIn();
            });
        });
    </script>';
            
               
                       
                
                //contenitore generale gallery
               
                //contenitore plugin gallery
                echo '<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 960px; height: 150px; overflow: hidden; clear:both">';
                
                echo ' <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                            background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
                        </div>
                        <div style="position: absolute; display: block;
                            top: 0px; left: 0px;width: 100%;height:100%;">
                        </div>
                    </div>';
                
                //contenitore delle slide
                echo '<div class="container-images" u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 960px; height: 150px; overflow: hidden;">';
                
                
                         
                    for($i=0; $i < count($result_get_images); $i++){
                        if($result_get_images[$i]->value != ''){
                            echo '<div><img u="image" src="'.$upload_dir['baseurl'].$result_get_images[$i]->value.'" /></div>'; 
                        }
                    }
                
                
                //fine contenitore delle slide
                echo '</div>';                  
                echo ' <!-- bullet navigator container -->
                        <div u="navigator" class="jssorb03" style="bottom: 4px; right: 6px;">
                            <!-- bullet navigator item prototype -->
                            <div u="prototype"><div u="numbertemplate"></div></div>
                        </div>';
               
                echo '<!-- Arrow Left -->
        <span u="arrowleft" class="jssora03l" style="top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora03r" style="top: 123px; right: 8px;">
        </span>';
                
                //fine contenitore plugin gallery
                echo '</div>';
                //fine contenitore generale gallery
                }
          }  
          echo '</div>';
          
          //ORARI DI APERTURA
          echo '<div id="orari-apertura">';
          if(getField(bp_displayed_user_id(), 'Lunedì') != null ||  
                  getField(bp_displayed_user_id(), 'Martedì') != null ||
                  getField(bp_displayed_user_id(), 'Mercoledì') != null ||
                  getField(bp_displayed_user_id(), 'Giovedì') != null ||
                  getField(bp_displayed_user_id(), 'Venerdì') != null ||
                  getField(bp_displayed_user_id(), 'Sabato') != null ||
                  getField(bp_displayed_user_id(), 'Domenica') != null){          
          ?>

        
            <h2>Orari di apertura</h2>
            <table>
               <?php if(getField(bp_displayed_user_id(), 'Lunedì') != null) { ?><tr><td>LUN</td><td><?php echo getField(bp_displayed_user_id(), 'Lunedì') ?></td></tr><?php } ?>
               <?php if(getField(bp_displayed_user_id(), 'Martedì') != null) { ?><tr><td>MAR</td><td><?php echo getField(bp_displayed_user_id(), 'Martedì') ?></td></tr><?php } ?>
               <?php if(getField(bp_displayed_user_id(), 'Mercoledì') != null) { ?><tr><td>MER</td><td><?php echo getField(bp_displayed_user_id(), 'Mercoledì') ?></td></tr><?php } ?>
               <?php if(getField(bp_displayed_user_id(), 'Giovedì') != null) { ?><tr><td>GIO</td><td><?php echo getField(bp_displayed_user_id(), 'Giovedì') ?></td></tr><?php } ?>
               <?php if(getField(bp_displayed_user_id(), 'Venerdì') != null) { ?><tr><td>VEN</td><td><?php echo getField(bp_displayed_user_id(), 'Venerdì') ?></td></tr><?php } ?>
               <?php if(getField(bp_displayed_user_id(), 'Sabato') != null) { ?><tr><td>SAB</td><td><?php echo getField(bp_displayed_user_id(), 'Sabato') ?></td></tr><?php } ?>
               <?php if(getField(bp_displayed_user_id(), 'Domenica') != null) { ?><tr><td>DOM</td><td><?php echo getField(bp_displayed_user_id(), 'Domenica') ?></td></tr><?php } ?>
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
          
          echo '</div>';
          //FINE ORARI DI APERTURA
           echo '<div id="info_address">';
                    $result_get_address = getAddress($id_user);
                    if(count($result_get_address) > 0){
                        //echo '<h2>RECAPITI</h2>';
//                        for($i=0; $i < count($result_get_address); $i++){
//                            echo '<h3>'.$result_get_address[$i]->name.'</h3><span class="field">'.$result_get_address[$i]->value.'</span>';
//                        }                               
                        echo '<h2>Mappa</h2>';
                        echo '<iframe
                                width="250"
                                height="100"
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
                    
                echo '</div>';
            }
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
        }
        
        
        
}


