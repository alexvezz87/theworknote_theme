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
class Matching extends WP_Widget {
    //put your code here
    
        public function Matching() {
		// Instantiate the parent object
		
		parent::__construct(
			'widget_matching', // Base ID
			__( 'Visualizza matching', 'Widget che visualizza i matching tra i diversi utenti' ), // Name
			array( 'description' => __( 'Visualizza matching', 'Widget che visualizza i matching tra i diversi utenti' ), ) // Args
		);
	
	}

	public function widget( $args, $instance ) {
            // Widget output 
            $printer = new SottocategoriaView();
            $idUtente = get_current_user_id();
            
            
            if($idUtente != 0){
                //utente loggato
                $printer->printWidgetMatching($idUtente, 1);               
            }
            else{
                //utente non loggato
            }
            
        ?>
            
        <?php
           
            
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
	}

	function form( $instance ) {
		// Output admin widget options form
        }
        
        
        
}


