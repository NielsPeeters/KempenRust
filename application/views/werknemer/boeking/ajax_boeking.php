<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Include Bootstrap Datepicker -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

<script>
 $(document).ready(function(){
   $('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    startDate: '1d'
});

$.fn.datepicker.defaults.format = "mm/dd/yyyy";
$('.datepicker').datepicker({
    startDate: '-3d'
});

 });

</script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('boeking/schrijfBoeking', $attributes);
?>

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

     <div class="form-group">
        <label for="startDatum" class="control-label ">van:</label>
        <div class="input-group date">
        <?php 
        echo form_input(array('data-provide'=>'datepicker-inline','name' => 'startDatum', 'id' => 'startDatum', 'value' => $boeking->startDatum, 'class' => 'form-control datepicker', 'placeholder' => 'startDatum', 'required' => 'required'));?>
         <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
        </div>
    </div>
    <div class="form-group ">
        <label for="eindDatum" class="control-label">tot:</label>
        <div class="input-group date">
        <?php 
        echo form_input(array('data-provide'=>'datepicker-inline','name' => 'eindDatum', 'id' => 'eindDatum', 'value' => $boeking->eindDatum,'data-date-format'=>'dd/mm/yyyy', 'class' => 'form-control datepicker', 'placeholder' => 'eindDatum', 'required' => 'required'));?>
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
        </div>
    </div>
    </br>
    </br>



    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $boeking->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    
    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-secondary">Annuleren</p>'); ?>
    <button type="button" data-id="' . $boeking->id . '" class="btn btn-warning verwijder">Verwijderen</button>
   
    <button type="submit" data-id="' . $boeking->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>