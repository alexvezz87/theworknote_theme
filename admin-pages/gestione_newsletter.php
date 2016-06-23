<?php

//Autore: Alex Vezzelli - Alex Soluzioni Web
//url: http://www.alexsoluzioniweb.it/

date_default_timezone_set('Europe/Rome');
$oggi = time();
$settimana = 7*24*60*60;
$mese = 30*24*60*60;
$anno = 365*24*60*60;

$ultimaSettimana = date("Y-m-d H:i:s", $oggi - $settimana);
$ultimoMese = date("Y-m-d H:i:s", $oggi - $mese);
$ultimoAnno = date("Y-m-d H:i:s", $oggi - $anno);

$utenti = array();

//LISTENER
if(isset($_POST['invia-periodo'])){
    
    $temp = explode(';', $_POST['periodo']);
    
    $parametri[0] = $temp[1];
    $parametri[1] = date("Y-m-d H:i:s",$oggi);
    $utenti = getUpdatesUtente($parametri);
    
    //Sistema per scremare l'utente con più attività di una determinata categoria
    $scrematura = array();
    $categorie = array();
    foreach($utenti as $utente){
        
        $trovato = false;
        $i = 0;
        while($trovato == false && $i < count($categorie)){
            if($categorie[$i] == $utente->categoria){
                $trovato = true;
            }
            $i++;
        }
        
        if($trovato == false){
            array_push($categorie, $utente->categoria);
            array_push($scrematura, $utente);
        }
        
    }
    
}

?>

<h1>Gestione Newsletter</h1>

<form action="<?php curPageURL() ?>" method="POST">
    <label>
        Seleziona il periodo
    </label>
    
    <div>
        <input type="radio" name="periodo" value="<?php echo 'settimana;'.$ultimaSettimana ?>" <?php if(isset($temp[0])){if($temp[0] == 'settimana'){echo 'checked';}} ?> />L'ultima settimana<br>
        <input type="radio" name="periodo" value="<?php echo 'mese;'.$ultimoMese ?>" <?php if(isset($temp[0])){if($temp[0] == 'mese'){echo 'checked';}} ?> />L'ultimo mese<br>
        <input type="radio" name="periodo" value="<?php echo 'anno;'.$ultimoAnno ?>" <?php if(isset($temp[0])){if($temp[0] == 'anno'){echo 'checked';}} ?> />L'ultimo anno
    </div>
    
    <div>
        <input type="submit" name="invia-periodo" value="CERCA" />
    </div>
</form>

<?php 
      
if(count($scrematura) > 0){
    $periodo = "";
    if(isset($temp[0])){
        if($temp[0] == 'settimana'){
            $periodo = "nell'ultima settimana";
        }
        else if($temp[0] == 'mese'){
            $periodo = "nell'ultimo mese";
        }
        else if($temp[0] == 'anno'){
            $periodo = "nell'ultimo anno";
        }
    }
    
    
?>
<h3>Attività utenti <?php echo $periodo ?> </h3>
<table class="table-cvs">
    <thead>
    <tr class="intestazione">
        <td>Categoria</td>
        <td>Utente</td>        
        <td>Num. attività</td>        
        <td>Azione</td>
    </tr>
    </thead>
    <tbody>
<?php
    foreach($scrematura as $utente){
        $user_info = get_userdata($utente->user_id);
?>
        <tr>
            <td class="categoria"><?php echo $utente->categoria ?></td>
            <td class="utente"><?php echo $user_info->display_name ?></td>
            <td><?php echo $utente->attivita ?></td>
            <td>
                <input type="hidden" name="periodo" value="<?php echo $periodo ?>" />
                <input class="crea-newsletter" type="button" value="CREA NEWSLETTER" />
            </td>
        </tr>
<?php
    }
}
?>
    </tbody>
</table>

<div id="container-code-newsletter" >
    <h4>Codice newsletter</h4>
    <pre id="code-newsletter" contenteditable="true"></pre>
    <h4 id="categoria-email"></h4>
    <pre id="lista-email" contenteditable="true">
        <?php
            //stampa della lista mail di una determinata categoria
            
        ?>
    </pre>
</div>

<script>
jQuery( document ).ready(function($) {
    $('input.crea-newsletter').click(function(){
        $('#container-code-newsletter').hide();
        //ottengo i valori delle variabili interessanti
        var categoria = $(this).parent('td').siblings('.categoria').text();
        var utente = $(this).parent('td').siblings('.utente').text();
        var periodo = $(this).siblings('input[name=periodo]').val();
        
        var html = "La categoria "+categoria+" "+periodo+" ha avuto "+utente+" come utente più attivo!";
        $('#container-code-newsletter pre#code-newsletter').text(html);
        
        
        //chiamata ajax per popolare la lista di email di una determinata categoria
        $.ajax({
            type:'POST',
            dataType: 'json',
            url: '<?php echo get_home_url().'/wp-admin/admin-ajax.php' ?>',
            data: {
                action: 'my_ajax_get_emails',
                categoria: categoria
            },
            success : function(data){
                var html = "";
                for(var i=0; i < data.length; i++){                   
                    html+=data[i]+'<br>';                    
                }
                $('#categoria-email').text('Lista di email appertenti alla categoria: '+categoria);
                $('#container-code-newsletter pre#lista-email').html(html);
                $('#container-code-newsletter').show();
            },
            error : function(){
                alert('error');
            }
               
        });
        
        
    });
});

</script>
 

