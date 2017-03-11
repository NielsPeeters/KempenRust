<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script>
    $(document).ready(function () {
        $('.pause').click(function (e) {
            $('#myForm').validator();
        });
    });


</script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','id'=>'JqAjaxForm');
echo form_open('TypePersoon/schrijfTypePersoon', $attributes);
?>

<form name='myform' id='JqAjaxForm'>
    <div class="form-group">
        <label for="omschrijving" class="control-label">Soort</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'soort', 'id' => 'soort', 'value' => $typePersoon->soort, 'class' => 'form-control', 'placeholder' => 'Soort', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="omschrijving" class="control-label">Korting</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'korting', 'id' => 'korting', 'value' => $typePersoon->korting, 'class' => 'form-control', 'placeholder' => 'Korting', 'required' => 'required')); ?>
    </div>
    </br>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $typePersoon->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>

    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $typePersoon->id . '" class="btn btn-warning verwijder">Verwijderen</button>
    <button type="submit" data-id="' . $typePersoon->id . '" class="btn btn-primary opslaan">Opslaan</button>
</div>
</form>