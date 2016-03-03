$( document ).ready(function() {
    
    //apro e chiudo l'hamburger menu del mobile
    $('.hambuger-menu').click(function(){
        $('.mobile-menu').show("slide", { direction: "right" }, 400);   
    });
    
    $('.mobile-menu .chiudi').click(function(){
        $('.mobile-menu').hide("slide", { direction: "right" }, 400); 
        $('.mobile-menu .sotto-menu').hide();
    });
    
    $('.mobile-menu').on('swipe', function(){
        $('.mobile-menu').hide("slide", { direction: "right" }, 400); 
        $('.mobile-menu .sotto-menu').hide();
    });
    
    //rimuovo l'admin bar standard
    if($('body.not-admin').size() > 0){
        $('body.not-admin #wpadminbar').remove();
        
        if($(window).width() > 782){
            $('header').css('margin-top', '-32px');
        }
        else{
            $('header').css('margin-top', '-46px');
        }
    }
    
    $(window).resize(function(){
        if($('body.not-admin').size() > 0){
            if($(window).width() > 782){
                $('header').css('margin-top', '-32px');
            }
            else{
                $('header').css('margin-top', '-46px');
            }
        }
    });
    
    //Gestione sottomenu
    $('.icona').click(function(event){        
        event.stopPropagation(); //IMPORANTE!
        //nascondo tutto
        hideSubMenus();
       
        //Mostro il triangolo
        $(this).find('.triangolo').show();
        //Mostro il submenus
        $('.submenus').show();
        //Mostro il submenu giusto
        $('.submenus div[data-name='+$(this).data('name')+']').show();
    });
    
    //nascondo tutto se clicco fuori
    $('html').click(function(){
        //nascondo tutto
        hideSubMenus();
    });
    
    function hideSubMenus(){
       //nascondo tutti i triagoli visibili
       $('.triangolo').hide();
       //nascondo il submenus
       $('.submenus').hide();
       //nascondo i suoi figli
       $('.sub-menu').hide();
    }
    
    //Gestione menu mobile
    $('.mobile-menu .riga, .mobile-menu .icona').click(function(){
       
       
        if($(this).hasClass('riga')){
            $(this).find('.sotto-menu').slideToggle();
        }
        else{
            $(this).siblings('.sotto-menu').slideToggle();
        }
    });
    
    
    
    
    
});


