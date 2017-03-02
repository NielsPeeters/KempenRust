<?php
echo javascript("validator.js");
//$attributes = array('name' => 'myform','id'=>'JqAjaxForm');
//echo form_open('kamer/schrijfJSONObject', $attributes);
?>

<form name='myform' id='JqAjaxForm'>
    <div class="form-group">
        <label for="omschrijving" class="control-label">Omschrijving</label>
<?php echo form_input(array('type' => 'text', 'name' => 'omschrijving', 'id' => 'omschrijving', 'value' => $type->naam, 'class' => 'form-control', 'placeholder' => 'Omschrijving', 'required' => 'required')); ?>
    </div>
    </br>

<?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $type->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>


    <button type="button" data-id="' . $type->id . '" class="btn btn-warning verwijder">Verwijderen</button>
<?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-secondary">Annuleren</p>'); ?>
    <button type="submit" data-id="' . $type->id . '" class="btn btn-primary opslaan">Opslaan</button>
</form>

