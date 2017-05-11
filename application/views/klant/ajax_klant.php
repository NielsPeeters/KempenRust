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
$attributes = array('name' => 'myform', 'id' => 'JqAjaxForm', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('klant/schrijfJSONObject', $attributes);
?>
<form name='myform' id='JqAjaxForm'>
    <div class="form-group">
        <label for="naam" class="control-label">Naam</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'naam', 'id' => 'naam', 'value' => $user->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="voornaam" class="control-label">Voornaam</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'voornaam', 'id' => 'voornaam', 'value' => $user->voornaam, 'class' => 'form-control', 'placeholder' => 'Voornaam', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="gemeente" class="control-label">Gemeente</label>
        <?php echo form_input(array('type' => 'text', 'name' => 'gemeente', 'id' => 'gemeente', 'value' => $user->gemeente, 'class' => 'form-control', 'placeholder' => 'gemeente', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="postcode" class="control-label">Postcode</label>
        <?php echo form_input(array('title' => ' postcode bestaat uit 4 cijfers.', 'pattern' => '[0-9]{4}', 'name' => 'postcode', 'id' => 'postcode', 'value' => $user->postcode, 'class' => 'form-control', 'placeholder' => 'Postcode', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="straat" class="control-label">Straat</label>
        <?php echo form_input(array('name' => 'straat', 'id' => 'straat', 'value' => $user->straat, 'class' => 'form-control', 'placeholder' => 'Straat', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="huisnummer" class="control-label">Huisnummer</label>
        <?php echo form_input(array('type' => 'number', 'name' => 'huisnummer', 'id' => 'huisnummer', 'value' => $user->huisnummer, 'class' => 'form-control', 'placeholder' => 'Huisnummer', 'required' => 'required')); ?>
    </div>

    <div class="form-group">
        <label for="bus" class="control-label">Bus</label>
        <?php echo form_input(array('name' => 'bus', 'id' => 'bus', 'value' => $user->bus, 'class' => 'form-control', 'placeholder' => 'Bus')); ?>
    </div>

    <div class="form-group">
        <label for="telefoon" class="control-label">Telefoon</label>
        <?php echo form_input(array('pattern' => '^\+?[0-9]{10}', 'name' => 'telefoon', 'id' => 'telefoon', 'value' => $user->telefoon, 'class' => 'form-control', 'placeholder' => 'Telefoon')); ?>
    </div>

    <div class="form-group">
        <label for="email" class="control-label">E-mail</label>
        <?php echo form_input(array('data-error' => 'This email address is invalid', 'type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => $user->email, 'class' => 'form-control', 'placeholder' => 'E-mail', 'required' => 'required', 'data-error' => 'Dit is geen correct e-mailadres.')); ?>
        <div class="help-block with-errors"></div>

    </div>

    <div class="form-group">
        <label for="wachtwoord" class="control-label">Wachtwoord</label>
        <div class="form-inline row">
            <div class="form-group col-sm-12">
                <input type="password" data-minlength="6" class="form-control" id="een" name="wachtwoord" placeholder="Wachtwoord">
                <div class="help-block">Minimum 6 karakters.</div>
            </div>
            <div class="form-group col-sm-12">
                <input type="password" class="form-control" id="wachtwoord" data-match="#een" name="wachtwoord" data-match-error="Deze wachtwoorden komen niet overeen!" placeholder="Herhaal wachtwoord">
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $user->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>

    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="submit" data-id="' . $type->id . '" class="btn btn-primary opslaan">Opslaan</button>
</div>
</form>