<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script>
    $(document).ready(function () {
        $('.pause').click(function (e) {
            $('#myForm').validator();
        });


        var soort = parseInt($('#soort').val()) - 1;
        $('.soort option:eq(' + soort + ')').prop('selected', true)
    });


</script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'id' => 'JqAjaxForm', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('persoon/schrijfJSONObject', $attributes);
?>

<form name='myform' id='JqAjaxForm'>
    <div class="form-group">
        <label for="naam" class="control-label">Naam</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'naam', 'id' => 'naam', 'value' => $klant->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="voornaam" class="control-label">Voornaam</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'voornaam', 'id' => 'voornaam', 'value' => $klant->voornaam, 'class' => 'form-control', 'placeholder' => 'Voornaam', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="gemeente" class="control-label">Gemeente</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'gemeente', 'id' => 'gemeente', 'value' => $klant->gemeente, 'class' => 'form-control', 'placeholder' => 'Gemeente', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="postcode" class="control-label">Postcode</label>
        <?php echo form_input(array('title' => ' postcode bestaat uit 4 cijfers.', 'pattern' => '[0-9]{4}', 'name' => 'postcode', 'id' => 'postcode', 'value' => $klant->postcode, 'class' => 'form-control', 'placeholder' => 'Postcode', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="straat" class="control-label">Straat</label>
        <?php echo form_input(array('name' => 'straat', 'id' => 'straat', 'value' => $klant->straat, 'class' => 'form-control', 'placeholder' => 'Straat', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="huisnummer" class="control-label">Huisnummer</label>
        <?php echo form_input(array('type' => 'number', 'name' => 'huisnummer', 'id' => 'huisnummer', 'value' => $klant->huisnummer, 'class' => 'form-control', 'placeholder' => 'Huisnummer', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="bus" class="control-label">Bus</label>
        <?php echo form_input(array('name' => 'bus', 'id' => 'bus', 'value' => $klant->bus, 'class' => 'form-control', 'placeholder' => 'Bus')); ?>
    </div>

    <div class="form-group">
        <label for="telefoon" class="control-label">Telefoon</label>
        <?php echo form_input(array('pattern' => '^\+?[0-9]{10}', 'name' => 'telefoon', 'id' => 'telefoon', 'value' => $klant->telefoon, 'class' => 'form-control', 'placeholder' => 'Telefoon')); ?>
    </div>

    <div class="form-group">
        <label for="email" class="control-label">E-mail</label>
        <?php echo form_input(array('data-error' => 'This e-mail address is invalid', 'type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => $klant->email, 'class' => 'form-control', 'placeholder' => 'E-mail', 'required' => 'required', 'data-error' => 'Dit is geen correct e-mailadres.')); ?>
        <div class="help-block with-errors"></div>

    </div>

    <div class="form-group">
        <label for="wachtwoord" class="control-label">Wachtwoord</label>
        <div class="form-inline row">
            <div class="form-group col-sm-12">
                <input type="password" data-minlength="6" class="form-control" id="een" placeholder="Wachtwoord" name="wachtwoord">
                <div class="help-block">Minimum 6 karakters.</div>
            </div>
            <div class="form-group col-sm-12">
                <input type="password" class="form-control" id="wachtwoord" data-match="#een" data-match-error="Deze wachtwoorden komen niet overeen!" placeholder="Herhaal wachtwoord" >
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>

    <div class=" form-group">
        <label for="soort" class="control-label">Soort</label>
        <select name="soort" class="soort form-control"> 
            <option value="1">Klant</option>
            <option value="2">Werknemer</option>
            <option value="3">Eigenaar</option>
        </select>
    </div>  
    </br>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'hiddensoort', 'id' => 'soort', 'value' => $klant->soort, 'class' => 'form-control', 'placeholder' => 'id')) ?>
    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $klant->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>

    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $klant->id . '" class="btn btn-warning verwijder">Verwijderen</button>
    <button type="submit" data-id="' . $klant->id . '" class="btn btn-primary opslaan">Opslaan</button>
</div>
</form>