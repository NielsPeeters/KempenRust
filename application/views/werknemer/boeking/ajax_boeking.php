
<script>


$(document).ready(function(){
    checkPension();

    $("#dropDown").change(function(){
        checkPension();
    });

   

    $(".kamerVerwijderen").click(function(){
        verwijderKamerBoeking($(".kamerVerwijderen").attr('id'));
    });
    
});

    function checkPension(){
        /*
        *Gaat na of het geselecteerde arrangement een pension is en geeft de pension dropdown weer indien dit zo is.
        */
        var naam = $('#dropDown').find(":selected").attr('id');
         $("#arrangementOmschrijving").html( $('#dropDown').find(":selected").val());
        if(naam=="0"){
            $('#dropDownPension').show();
        }else
        {
            $('#dropDownPension').hide();
           
        }
    }

  </script>

 
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'id' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('boeking/schrijfBoeking/', $attributes);
?>

     <div class="form-group"> <!--gast-->
     </br>
        <label for="persoon" class="control-label">Gast</label>
        
        <?php if(!$boeking->persoonId==0)
        {
            $naam=$boeking->persoon->naam . " ".$boeking->persoon->voornaam;
            echo form_input(array('disabled'=>'disabled', 'id' => 'persoon', 'value' => $naam, 'class' => 'form-control', 'placeholder' => 'Gast', 'required' => 'required'));
            echo form_input(array('type' => 'hidden', 'name' => 'persoonId', 'id' => 'persoonId', 'value' => $boeking->persoon->id, 'class' => 'form-control', 'placeholder' => 'persoonId'));
        }
              
        else
        { ?>
            <select  name="persoonId" class="form-control">
                <?php 
                foreach ($personen as $persoon) {
                    $naam=$persoon->naam . " ".$persoon->voornaam;?>
                    <option label="<?php echo $naam;?>" id="" value="<?php echo $naam;?>">
                    </option>
                
                <?php } ?>
            </select>  
             </br>
            <button class="btn btn-secondary pull-right"><?php echo anchor('/persoon/index/','Nieuwe gast'); ?></button>
            </br>
                 </div>  

            
        <?php   }?>
            </div>

    
    <div class="form-group row"> <!--Start + Einddatum-->
        <div class="col-xs-6">
            <label for="from" class="control-label ">Van</label>
            <input  type="date" data-fv-date-format="DD/MM/YYYY" class="form-control" id="beginDatum" name="startDatum" value=<?php echo $boeking->startDatum; ?> required>
        </div>
        <div class="col-xs-6">
            <label for="to" class="control-label">Tot</label>
            <input class="form-control" data-fv-date-format="DD/MM/YYYY" type="date" id="eindDatum" name="eindDatum" value=<?php echo $boeking->eindDatum; ?> required>
        </div>
    </div>

    <div class="form-group">

        <label for="persoontype" class="control-label">Aantal personen</label>
        <div>
        
        <?php 
   
 
   
    foreach ($typePersonen as $typePersoon) {
            $nieuw = TRUE;
            foreach($boekingTypePersonen as $boekingTypePersoon){
                if($boekingTypePersoon->typePersoonId == $typePersoon->id){
                  $nieuw = FALSE
                  ?>
                    <div class="col-xs-3">
                    <label for="persoontype" id="persoontype" class="control-label"><?php echo $typePersoon->soort;?></label>
                 <?php
                        echo form_input(array('class'=>'form-control','type' => 'number', 'name' => 'persoon' . $typePersoon->id, 'id' => 'persoon' . $typePersoon->id, 'required' => 'required', 'value' => $boekingTypePersoon->aantal));
                   ?>                    </div><?php  
                }
                
            }
            if($nieuw){?>
                   <div class="col-xs-3">
                        <label for="persoontype" id="persoontype" class="control-label"><?php echo $typePersoon->soort;?></label>
                        <?php
                        echo form_input(array('class'=>'form-control','type' => 'number', 'name' => 'persoon' . $typePersoon->id, 'id' => 'persoon' . $typePersoon->id, 'required' => 'required', 'value' => '0'));
                   ?>
                    
                    </div>
     <?php  
            }
        }
      


     ?>
     </div></div>
    </br>
    </br>
    </br>

     <div class="form-group"> <!--Arrangementen-->
        <label for="arrangement" class="control-label">Arrangement</label>
        <select id="dropDown" name="arrangement" class="form-control">
        <option id="0">Geen arrangement</option>
        <?php
        
            $value = $boeking->arrangementId;
          
            foreach ($arrangementen as $arrangement) {
                $type = $arrangement->id; ?>
                <option label="<?php echo $arrangement->naam;?>" id="<?php echo $arrangement->id;?>" value="<?php echo $arrangement->omschrijving;?>" <?php echo set_select('arrangement', $type, $type === $value);?>>
                <?php echo "$arrangement->id";
                ?>
                </option>
               
            <?php }?>
        </select>  
        </br>
        <div class="alert alert-success">
        <p  class="" id="arrangementOmschrijving"></p>
        </div>
    </div>  

    
     <div class="form-group" id="dropDownPension">
        <label for="pension" class="control-label">Pension</label>
        <?php
        $value = $boeking->arrangementId;
            ?>
           <select name="pension" class="form-control"><?php
            foreach ($pensions as $pension) { 
                $type = $pension->id; ?>
                <option  value="<?php echo $pension->id;?>" <?php echo set_select('pension', $type, $type === $value);?>>
                <?php echo "$pension->naam $pension->omschrijving";?>
                </option>
            <?php }?>
        </select>  

        </div>  
    </br>


<div class="form-group">
    <label for="opmerking" class="control-label">Opmerkingen (Allergieën, huisdieren, ...)</label>
    <textarea rows="3" type="text" class="form-control" name="opmerking"><?php echo $boeking->opmerking;?></textarea>
</div>




    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $boeking->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $boeking->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>

<!-- Modal -->
<div class="modal fade" id="waarschuwingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Waarschuwing</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>