
<script>

    $(document).ready(function(){
    });
</script>

<div id="inhoud">
<?php
echo javascript("validator.js");

?>
    <form name="kamerform" data-toggle="validator" id="kamerform" role="form" method="post">
    
    

        <?php
        $opties = array();
            foreach($kamers as $kamer) {
                $test = $kamer->type->omschrijving;
                $opties[$kamer->id] = "$kamer->naam" . ' &nbsp max: ' . $kamer->aantalPersonen .' personen &nbsp ' . $test . ' ';
            }
            if(count($opties)!=0){?>
            <div class="form-group">
   
        <p>Kies het aantal personen voor deze kamer:</p>
        <?php 

            echo form_input(array('class'=>'form-control','type' => 'number', 'name' => 'aantal', 'id' => 'aantal', 'required' => 'required', 'value' => '1'));
          ?>

    </div>

                <div class="form-group">
                <p>Welke kamer wil u toevoegen?</p>
            <?php
            echo form_dropdown('kamer', $opties, '1', 'id="kamer" size="10" class="form-control"');
            ?>
            </div>
       <div class="form-group">
        <p>Staat de kamer vast?</p>
        <?php 
            echo form_radio('voorkeur', '1', '', 'id="ja"') . form_label('Ja', 'ja');
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo form_radio('voorkeur', '0', '1', 'id="nee"') . form_label('Nee', 'nee');
        ?>
    </div>

        <a class="kamerToevoegen btn btn-primary">Toevoegen</a>
        
     <?php   }
        else {
            echo "<div class='alert alert-danger'><p>Er zijn geen kamers beschikbaar voor de geselecteerde datum.</p></div>";
        }
        ?>
    
<a class="annuleer btn btn-secondary">Annuleren</a>
    
    <?php //echo form_submit('submit', 'Toevoegen', 'class="btn btn-primary"');?>
<?php echo form_close();?>
</div>