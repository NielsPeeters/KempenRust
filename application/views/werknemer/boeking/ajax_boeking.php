<script>
$(document).ready(function(){
    $("#startDatum").val($.datepicker.formatDate('dd/mm/yy', $("#datum1").val()));
    $("#eindDatum").val($.datepicker.formatDate('dd/mm/yy', $("#datum1").val()));
    //$('#datum1').hide();
 
    $('#dropDownPension').hide();
    var uitleg= $("#dropDown").val();
    $("#arrangementOmschrijving").html(uitleg);
    $.fn.datepicker.defaults.language='nl';
    $.fn.datepicker.defaults.format='dd/mm/yy';
    $.fn.datepicker.defaults.autoclose=true;
    $("#from").datepicker({
        todayBtn:  1,
        autoclose: true,
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#to').datepicker('setStartDate', minDate);
    });
    
    $("#to").datepicker()
        .on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#from').datepicker('setEndDate', minDate);
        });

    checkPension();

    $("#dropDown").change(function(){
        $("#arrangementOmschrijving").html(this.value);
        //alert(this.value);
        if(this.value=="Half- of volpension."){
            $('#dropDownPension').show();
        }
        else{
              $('#dropDownPension').hide();
                var uitleg= $("#dropDown").val();
        }
    })
});

    $(document).on('click', function (e) {
        
    });


    function checkPension(){
        var naam = $('#dropDown').find(":selected").val();
        if(naam=="Half- of volpension."){
            $('#dropDownPension').show(); 
    }
    }
  </script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('boeking/schrijfBoeking', $attributes);
?>

     <div class="form-group">
        <label for="persoon" class="control-label">Gast</label>
        <?php if(!$boeking->persoonId==0){$naam=$boeking->persoon->naam . " ".$boeking->persoon->voornaam;
                echo form_input(array('disabled'=>'disabled','name' => 'persoon', 'id' => 'persoon', 'value' => $naam, 'class' => 'form-control', 'placeholder' => 'Gast', 'required' => 'required'));
}
        else{echo "TODO: gast selecteren of nieuwe gast maken";}?>
        </br>
    </div>

     <div class="form-group">
        <label for="arrangement" class="control-label">Arrangement</label>
        <select id="dropDown" name="arrangement" class="form-control">
        <?php
            $value = $boeking->arrangementId;?>
            <option value="Geen arrangement">Geen arrangement</option><?php
            foreach ($arrangementen as $arrangement) {
                $type = $arrangement->id; ?>
                <option  value="<?php echo $arrangement->omschrijving;?>" <?php echo set_select('arrangement', $type, $type === $value);?>>
                <?php echo "$arrangement->naam";?>
                </option>
     
            <?php }?>
        </select>  
        <p  class="bg-info" id="arrangementOmschrijving"></p>
    </div>  

    
     <div class="form-group" id="dropDownPension">
        <label for="pension" class="control-label">Pension</label>
        <?php
        $arrangementId = $boeking->arrangementId;
            foreach($arrangementen as $arrangement){
                if($arrangementId == $arrangement->id){
                    $pensionId = $arrangement->pensionId;
                }
            }
            ?>
           <select name="pension" class="form-control"><?php
            foreach ($pensions as $pension) { 
                $type = $pension->id; ?>
                <option  value="<?php echo $pension->naam;?>" <?php echo set_select('pension', $type, $type === $pensionId);?>>
                <?php echo "$pension->naam";?>
                </option>
            <?php }?>
        </select>  

    </div>  
    <p id="datum1"><?php echo $boeking->startDatum; ?></p>
    </br>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="from" class="control-label ">Van</label>
            <input  type="text" class="form-control" id="from" name="startDatum" value=<?php echo $boeking->startDatum; ?> required>
        </div>
        <div class="col-xs-6">
            <label for="to" class="control-label">Tot</label>
            <input class="form-control" type="text" id="to" name="eindDatum" value=<?php echo $boeking->eindDatum; ?> required>
        </div>
    </div>


       <div class="form-group" id="dropDownPension">
        <label for="kamerBoeking"  class="control-label" data-toggle="tooltip" title="Selecteer meerdere kamers door de CTRL toets ingedrukt te houden.">Geboekte kamers</label>
         <select size="10" class="selectpicker form-control"  name="kamerBoeking" multiple>
        <?php
        foreach($kamers as $kamer){
            $rij =  array();
            foreach($kamerBoekingen as $kamerBoeking){
                array_push($rij,$kamerBoeking->kamerId);
            }
                if(in_array($kamer->id, $rij) ){
                     ?>
                        <option selected><?php echo $kamer->naam . " " . $kamer->type->omschrijving;?></option>
                    <?php
                
                }else{
                     ?>
                <option><?php echo $kamer->naam . " " . $kamer->type->omschrijving;?></option>
           <?php
                }
               
            }
            ?>
                  </select>
    </div>  


<div class="form-group row">
<?php   $totaal=0;
        foreach ($typePersonen as $typePersoon) {
            //echo $typePersoon->id;
            //echo "test typepersoon </br>";
            foreach($boekingTypePersonen as $boekingTypePersoon){
                //echo $boekingTypePersoon->typePersoonId;
                //echo "test boekingtypepersoon </br>";
               
                if($boekingTypePersoon->typePersoonId == $typePersoon->id){
                    //echo "test ze zijn gelijk";
                    $totaal += $boekingTypePersoon->aantal;?>
                    <div class="col-xs-3">
                        <label for="typePersoon" id="typePersoon" class="control-label"><?php echo $typePersoon->soort;?></label>
                        <input class="form-control" type="number" id="to" name="to" value="<?php echo $boekingTypePersoon->aantal;?>" required>
                    </div><?php  
                }
            }
        }
      ?>
</div>
</br>
<div class="form-group" id="totaal">
    <label for="aantalMensen" class="control-label">Totaal aantal personen</label>
    <input class="form-control" type="number" id="" name="to" value="<?php echo $totaal;?>" disabled>
</div>

<div class="form-group">
    <label for="opmerking" class="control-label">Opmerkingen</label>
    <textarea rows="3" class="form-control" name="opmerking"><?php echo $boeking->opmerking;?></textarea>
</div>

<div class="form-group">
        <label for="goedgekeurd" class="control-label">Goedgekeurd</label>
        <?php 
        if($boeking->goedgekeurd=='1'){
            echo "<div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='1' checked>Ja";
            echo "</div><div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='0' >Nee</div>";}
        else{
            echo "<div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='1' >Ja";
            echo "</div><div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='0' checked>Nee</div>";}?>
</div>
</br>




    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $boeking->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    
    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-secondary">Annuleren</p>'); ?>
    <button type="button" data-id="' . $boeking->id . '" class="btn btn-warning verwijder">Verwijderen</button>
   
    <button type="submit" data-id="' . $boeking->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>