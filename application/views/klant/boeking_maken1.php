<script>
/**
* \file
*/
    $(document).ready(function(){
        var arrangementId;
        $("#geenArrangement").hide();

        $("#arrangement").change(function() {
            /**
            *Bij het veranderen van de geselecteerde arrangement, kijkt het systeem of er een arrangement is geselecteerd of de optie 'Geen arrangement' is geselecteerd
            */
            arrangementId = $(this).val();
            
            if(arrangementId == 0) {
                $("#geenArrangement").show();
            } else {
                $("#geenArrangement").hide();
            }
        });
        
        $('#volgende').click(function() {
            /** 
            * begindag
            */
            var msec = Date.parse($("#begindatum").val());
            var begindatum = new Date(msec);
            var dagen = ["zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag"];
            var begindag = dagen[begindatum.getDay()];
            
            /**
            * einddag
            */
            msec = Date.parse($("#einddatum").val());
            var einddatum = new Date(msec);
            var einddag = dagen[einddatum.getDay()];
            
            /**
             * haal begin- en einddag van het arrangement uit de database
             */
            if (arrangementId > 0) {
                <?php foreach ($arrangementen as $a) {?>
                    var id = <?php echo $a->id;?>;
                    if (arrangementId == id){
                        alert(<?php echo $a->beginDag;?>);
                        //var arrangementBegin = <?php echo $a->beginDag;?>;
                        //var arrangementEind = <?php echo $a->eindDag;?>;
                        //alert("arrangement: " + arrangementBegin + " - " + arrangementEind);
                    }
                <?php }?>
            }
        });
    });
</script>

<?php 
    $optionsArrangementen = array();
    $optionsArrangementen[0] = "Geen arrangement";
    foreach($arrangementen as $arrangement){
	$optionsArrangementen[$arrangement->id] = $arrangement->naam;
    }
    
    $optionsPensions = array();
    foreach($pensions as $pension) {
        $optionsPensions[$pension->id] = $pension->naam;
    }
?>

<div class="row">
    <?php 
        echo javascript("validator.js");
        $attributes = array('name' => 'myform', 'id' => 'myform', 'data-toggle'=>'validator','role'=>'form');
        echo form_open('klant/arrangementGekozen', $attributes);
    ?>
    
    <h4>Kies een begin- en einddatum:</h4>
    
    <div class="form-group">
        <p>
            <?php echo form_label('Begindatum:', 'begindatum'); ?>
            <?php echo form_input(array('type' => 'date', 'name' => 'begindatum', 'id' => 'begindatum', 'required' => 'required')); ?>
        </p>
        <div class="help-block with-errors"></div>  
    </div>
       
    <div class="form-group">
        <p>
            <?php echo form_label('Einddatum:', 'einddatum'); ?>
            <?php echo form_input(array('type' => 'date', 'name' => 'einddatum', 'id' => 'einddatum', 'required' => 'required')); ?>
        </p>
        <div class="help-block with-errors"></div>  
    </div>
    
    <h4>Kies een arrangement:</h4>
    
    <div class="form-group">
        <div class="col-lg-12">
            <div class="col-md-4">
                <?php echo form_dropdown('arrangement', $optionsArrangementen, '-1', 'id="arrangement" size="10" class="form-control" required="required"'); ?>
            </div>
            <div class="col-md-8"></div>
        </div>
        <div class="help-block with-errors"></div>  
    </div>
    
    <p>&nbsp;</p>
    
    <div id="geenArrangement">
        <h4>Geen arrangement</h4>
    
        <div class="form-group">
            <div class="col-lg-12">
                <div class="col-md-4">
                    <?php echo form_dropdown('pension', $optionsPensions, '-1', 'id="pension" size="10" class="form-control"'); ?>
                </div>
                <div class="col-md-8"></div>
            </div>
            <div class="help-block with-errors"></div>  
        </div>
        
        <p>&nbsp;</p>
    </div>
    
    <button type="button" class="btn btn-secondary annuleren"><?php echo anchor('home/index', 'Annuleren');?></button>
    <button type="button" class="btn btn-primary opslaan" id="volgende">Volgende</button>
    
    <?php echo form_close();?>
</div>

<?php echo "</tbody></table>";?>

<p>
  <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>

