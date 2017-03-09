<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script>
 $(document).ready(function(){
    /*$("#geenArrangement").hide();

    checkArrangement();
    

    $('select').change(function(){    
            alert("ja");
            var optionValue = $("#dropDown").val();
            if(optionValue=="geenArrangement"){
               $("#geenArrangement").show();
            } 
            else{
                $("#geenArrangement").hide();
            }
        
    })


    function checkArrangement(){
        alert("nee");
        if($("#check").val()==NULL){
            
                $("#geenArrangement").show();
            }
             else{
                $("#geenArrangement").hide();
            }
    }*/

    $('.opslaan').click(function(e){
        /**
        *Bij een klik op de opslaan knop wordt het form gevalideert.
        */
        $('#myForm').validator();
    });
 });


</script>
<?php echo javascript("validator.js");?>

<form name='myform' id='JqAjaxForm'>

     <div class="form-group">
        <label for="persoon" class="control-label">Gast</label>
        
        <?php $naam=$boeking->persoon->naam . " ".$boeking->persoon->voornaam;
        echo form_input(array('disabled'=>'disabled','name' => 'persoon', 'id' => 'persoon', 'value' => $naam, 'class' => 'form-control', 'placeholder' => 'Gast', 'required' => 'required'));?>
        </br>
    </div>

    <input id="check" type="hidden" value=<?php echo $boeking->arrangementId;?>/>
     <div class="form-group">
        <label for="arrangement" class="control-label">Arrangement</label>
        <select id="dropDown" name="arrangement" class="form-control">
        <?php
            $value = $boeking->arrangementId;?>
            <option value="geenArrangement">Geen arrangement</option><?php
            foreach ($arrangementen as $arrangement) {
                $type = $arrangement->id; ?>
                <option value=<?php echo $type; ?> <?php echo set_select('arrangement', $type, $type === $value);?>>
                <?php echo "$arrangement->naam";?>
                </option>
            <?php }?>
        </select>  
    </div>  
    </br>

    <!--<div id="geenArrangement">jdfmsqlfqmd</div>-->

    <div class="form-group">
        <label for="beschikbaar" class="control-label">Beschikbaarheid</label>
        <?php 
        if($boeking->beschikbaar==1){
            echo "<div><input type='radio' name='beschikbaar' id='beschikbaar' value='1' checked>Beschikbaar";
            echo "</div><div><input type='radio' name='beschikbaar' id='beschikbaar' value='0' >Niet beschikbaar</div>";}
        else{
            echo "<div><input type='radio' name='beschikbaar' id='beschikbaar' value='1' >Beschikbaar";
            echo "</div><div><input type='radio' name='beschikbaar' id='beschikbaar' value='0' checked>Niet beschikbaar</div>";}?>
    </div>
    </br>

    

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $boeking->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    
    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-secondary">Annuleren</p>'); ?>
    <button type="button" data-id="' . $boeking->id . '" class="btn btn-warning verwijder">Verwijderen</button>
   
    <button type="submit" data-id="' . $boeking->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>