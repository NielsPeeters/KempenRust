<script>

 function verwijderKamerBoeking(id) 
        {
            /**
            * Verwijderd te boeking die behoort tot het meegegeven id
            * \param id het id van de te verwijderen boeking als int
            * een leeg boeking object genereren als de boeking verwijderd kan worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/kamerBoeking/verwijder",
                data: {id: id},
                dataType: "text",
                success: function (result) {
            
                        alert(result);
                        location.reload();
                   
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + status + error);
                }
            });
        }

 function haalKamers (id) 
        {
            /**
            *\TODO
            */
            alert('ja');
          $.ajax({type : "GET",
            url : site_url + "/kamerBoeking/getWithBoeking",
            data : { id : id },
            success : function(result){
                $("#resultaat").html(result);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

$(document).ready(function(){
    checkPension();

    $("#dropDown").change(function(){
        checkPension();
    });

    $(".opslaan").click(function(){// datums validatie
         /** 
            * begindag
            */
            var msecBegin = Date.parse($("#beginDatum").val());
            var begindatum = new Date(msecBegin);
            var dagen = ["zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag"];
            var begindag = dagen[begindatum.getDay()];
            /**
            * einddag
            */
            var msecEind = Date.parse($("#eindDatum").val());
            var einddatum = new Date(msecEind);
            var einddag = dagen[einddatum.getDay()];
            var arrangementId = $("#dropDown").find(":selected").text();
            /**
             * haal begin- en einddag van het arrangement uit de database
             */
            var vandaag = new Date();
            vandaag = Date.parse(vandaag);
                
            if (msecBegin > vandaag) {
                if (msecEind > msecBegin) {
                    if(arrangementId > 0){
                        <?php foreach($arrangementen as $arrangement){?>
                            if (arrangementId == <?php echo $arrangement->id;?>){
                                if (begindag == "<?php echo $arrangement->beginDag;?>"){
                                    if (einddag == "<?php echo $arrangement->eindDag;?>"){
                                        $('#myform').submit();
                                    } else {
                                        alert("Einddatum is geen <?php echo $arrangement->eindDag;?>!");
                                    }
                                } else {
                                    if (einddag == "<?php echo $arrangement->eindDag;?>"){
                                        alert("Begindatum is geen <?php echo $arrangement->beginDag;?>!");
                                    } else {
                                        alert("Begindatum is geen <?php echo $arrangement->beginDag;?> en einddatum is geen <?php echo $arrangement->eindDag;?>!");
                                    }
                                }
                            }
                        <?php }?>
                    } else {
                        alert("succes");
                        $('#myform').submit();
                    }
                } else {
                    $(".modal-body").html('Einddatum valt vroeger dan begindatum!');
                    $("#waarschuwingModal").modal('show');
                }
            } else {
                  $(".modal-body").html('Begindatum valt vroeger dan vandaag!');
                  $("#waarschuwingModal").modal('show');
            }
    });

    $(".kamerVerwijderen").click(function(){
        verwijderKamerBoeking($(".kamerVerwijderen").attr('id'));
    });
    
});

    function checkPension(){
        var naam = $('#dropDown').find(":selected").attr('id');
         $("#arrangementOmschrijving").html( $('#dropDown').find(":selected").val());
        if(naam=="0"){
            $('#dropDownPension').show();
        }else
        {
            $('#dropDownPension').hide();
           
        }
    }

    function wijzigKamers(){
        $("#wijzigenModal").modal('show');
    }
  </script>

 
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('boeking/schrijfBoeking', $attributes);
?>


     <div class="form-group"> <!--gast-->
        <label for="persoon" class="control-label">Gast</label>
        <?php if(!$boeking->persoonId==0){$naam=$boeking->persoon->naam . " ".$boeking->persoon->voornaam;
                echo form_input(array('disabled'=>'disabled','name' => 'persoon', 'id' => 'persoon', 'value' => $naam, 'class' => 'form-control', 'placeholder' => 'Gast', 'required' => 'required'));}
        else{echo "TODO: gast selecteren of nieuwe gast maken";}?>
     
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

     <div class="form-group"> <!--Arrangementen-->
        <label for="arrangement" class="control-label">Arrangement</label>
        <select id="dropDown" name="arrangement" class="form-control">
        <?php
            $value = $boeking->arrangementId;?>
            <?php 
            foreach ($arrangementen as $arrangement) {
                $type = $arrangement->id; ?>
                <option label="<?php echo $arrangement->naam;?>" id="<?php echo $arrangement->isArrangement;?>" value="<?php echo $arrangement->omschrijving;?>" <?php echo set_select('arrangement', $type, $type === $value);?>>
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
    </br>



       <div class="form-group" id=""> <!--kamers-->
        <label for="kamerBoeking"  class="control-label">Geboekte kamers</label>
         <table class="table table-condensed">
         <tr class="success">
            <th >Kamer</th>
            <th >Type</th>
            <th >Aantal personen</th>

         </tr>
        <?php
        foreach($kamers as $kamer){
            $teller=0;
            $rij =  array();
            foreach($kamerBoekingen as $kamerBoeking){
                array_push($rij,$kamerBoeking->kamerId);
            }
                if(in_array($kamer->id, $rij) ){
                     ?>
                     <tr>
                        <td><?php echo $kamer->naam; ?></td>
                        <td><?php echo $kamer->type->omschrijving; ?></td>
                        <?php foreach($kamerBoekingen as $kamerBoeking){
                            if($kamerBoeking->kamerId==$kamer->id){?>
                               <td><?php echo $kamerBoeking->aantalMensen;?> </td>

                               <?php
                            }
                        }?>
                     </tr>
                    <?php
                
                }
            }
            ?>
                  </table>
    </div>  
    

    </br></br>
    <div class="form-group row">
    <div id="resultaat"></div>
    </div>

<div class="form-group row"> <!--typepersonen-->
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


<div class="form-group"> <!--goedgekeurd-->
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
    
    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $boeking->id . '" class="btn btn-warning verwijder">Verwijderen</button>
   
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