<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<?php echo javascript("validator.js"); ?>

<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('menu/schrijfMenu', $attributes);
?>

<div class="form-group">
    <label for="naam" class="control-label">Naam</label>
    <?php echo form_input(array('data-match' => '', 'type' => 'text', 'name' => 'naam', 'id' => 'naam', 'value' => $menu->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>


</div>
</br>

<?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $menu->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

<div class="help-block with-errors"></div>

<button type="button" class="btn btn-secondary annuleren">Annuleren</button>
<button type="button" data-id="' . $menu->id . '" class="btn btn-warning verwijder">Verwijderen</button>
<button type="submit" data-id="' . $menu->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>

