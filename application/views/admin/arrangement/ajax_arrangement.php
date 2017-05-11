<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('arrangement/schrijfArrangement', $attributes);
?>

<div class="form-group">
    <label for="naam" class="control-label">Naam</label>
    <?php echo form_input(array('data-match' => '', 'type' => 'text', 'name' => 'naam', 'id' => 'naam', 'value' => $arrangement->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
</div>
</br>

<div class="form-group">
    <label for="naam" class="control-label">Begindag</label>
    <?php echo form_input(array('data-match' => '', 'type' => 'text', 'name' => 'begindag', 'id' => 'begindag', 'value' => $arrangement->beginDag, 'class' => 'form-control', 'placeholder' => 'Begindag', 'required' => 'required')); ?>
</div>
</br>

<div class="form-group">
    <label for="naam" class="control-label">Einddag</label>
    <?php echo form_input(array('data-match' => '', 'type' => 'text', 'name' => 'einddag', 'id' => 'einddag', 'value' => $arrangement->eindDag, 'class' => 'form-control', 'placeholder' => 'Einddag', 'required' => 'required')); ?>
</div>
</br>

<div class="form-group">
    <label for="naam" class="control-label">Omschrijving</label>
    <?php echo form_textarea(array('data-match' => '', 'name' => 'omschrijving', 'id' => 'omschrijving', 'value' => $arrangement->omschrijving, 'class' => 'form-control', 'placeholder' => 'Omschrijving', 'required' => 'required')); ?>
</div>
</br>

<?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $arrangement->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

<div class="help-block with-errors"></div>

<button type="button" class="btn btn-secondary annuleren">Annuleren</button>
<button type="button" data-id="' . $pension->id . '" class="btn btn-warning verwijder">Verwijderen</button>
<button type="submit" data-id="' . $pension->id . '" class="btn btn-primary opslaan">Opslaan</button>


</form>