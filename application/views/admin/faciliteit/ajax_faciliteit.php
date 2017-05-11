<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<?php echo javascript("validator.js");?>

<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('faciliteit/schrijfFaciliteit', $attributes);
?>

    <div class="form-group">
        <label for="naam" class="control-label">Naam</label>
        <?php echo form_input(array('data-match'=>'','type'=>'text','name' => 'naam','id' => 'naam', 'value' => $faciliteit->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required'));?>
        
        
    </div>
    </br>

    <div class="form-group">
        <label for="prijs" class="control-label">Prijs</label>
<<<<<<< HEAD
        <?php echo form_input(array('type' => 'number', 'step' => '0.01', 'name' => 'prijs', 'id' => 'prijs', 'value' => $faciliteit->prijs, 'class' => 'form-control', 'placeholder' => 'Max. aantal personen', 'required' => 'required'));?>
=======
        <?php echo form_input(array('type' => 'number','step' => '0.01', 'name' => 'prijs', 'id' => 'prijs', 'value' => toKomma($faciliteit->prijs), 'class' => 'form-control', 'placeholder' => '0,00', 'required' => 'required'));?>
>>>>>>> 072f6d6afb4e4e74295e9045c53e2654595858d2
        </br>
    </div>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $faciliteit->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    
    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $faciliteit->id . '" class="btn btn-warning verwijder">Verwijderen</button>
    <button type="submit" data-id="' . $faciliteit->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>
