<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('pension/schrijfPension', $attributes);
?>

<div class="form-group">
    <label for="naam" class="control-label">Naam</label>
    <?php echo form_input(array('data-match' => '', 'type' => 'text', 'name' => 'naam', 'id' => 'naam', 'value' => $pension->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
</div>
</br>


<div class="form-group">
    <label for="omschrijving" class="control-label">Omschrijving</label>
    <?php echo form_input(array('data-match' => '', 'type' => 'text', 'name' => 'omschrijving', 'id' => 'omschrijving', 'value' => $pension->omschrijving, 'class' => 'form-control', 'placeholder' => 'Omschrijving')); ?>
</div>
</br>

<?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $pension->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>


<button type="button" class="btn btn-secondary annuleren">Annuleren</button>
<button type="button" data-id="' . $pension->id . '" class="btn btn-warning verwijder">Verwijderen</button>
<button type="submit" data-id="' . $pension->id . '" class="btn btn-primary opslaan">Opslaan</button>


</form>