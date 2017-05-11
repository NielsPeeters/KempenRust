<script>

    $(document).ready(function () {
        $('#labelEmail').hide();
        var emailVrij = "<?php echo $emailVrij; ?>";
        checkemailVrij(emailVrij);
        $('[data-toggle="tooltip"]').tooltip();
    });

    function checkemailVrij(emailVrij) {
        /**
         *Gaat na of het opgegeven email adres vrij is, zo niet wordt een label weergegeven.
         */
        if (emailVrij === "0") {
            $('#labelEmail').show();
            $("body, html").animate({scrollTop: $('#labelEmail').offset().top}, 600);
        }

    }

</script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('persoon/registreer', $attributes);
?>




<div class="form-group">
    <label for="naam" class="control-label">Naam</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je voornaam op", 'type' => 'text', 'name' => 'naam', 'id' => 'naam', 'value' => $persoon->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="voornaam" class="control-label">Voornaam</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je achternaam op", 'type' => 'text', 'name' => 'voornaam', 'id' => 'voornaam', 'value' => $persoon->voornaam, 'class' => 'form-control', 'placeholder' => 'Voornaam', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="gemeente" class="control-label">Gemeente</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je gemeente op", 'type' => 'text', 'name' => 'gemeente', 'id' => 'gemeente', 'value' => $persoon->gemeente, 'class' => 'form-control', 'placeholder' => 'gemeente', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="postcode" class="control-label">Postcode</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => 'Geef je postcode op, deze bestaat uit 4 cijfers.', 'pattern' => '[0-9]{4}', 'name' => 'postcode', 'id' => 'postcode', 'value' => $persoon->postcode, 'class' => 'form-control', 'placeholder' => 'Postcode', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="straat" class="control-label">Straat</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je straatnaam op", 'pattern' => '[a-zA-Z\s]+', 'name' => 'straat', 'id' => 'straat', 'value' => $persoon->straat, 'class' => 'form-control', 'placeholder' => 'Straat', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="huisnummer" class="control-label">Huisnummer</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je huisnummer op", 'type' => 'number', 'name' => 'huisnummer', 'id' => 'huisnummer', 'value' => $persoon->huisnummer, 'class' => 'form-control', 'placeholder' => 'Huisnummer', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="bus" class="control-label">Bus</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef indien nodig je bus op", 'name' => 'bus', 'id' => 'bus', 'value' => $persoon->bus, 'class' => 'form-control', 'placeholder' => 'Bus')); ?>
</div>

<div class="form-group">
    <label for="telefoon" class="control-label">Telefoon</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je telefoonnummer op", 'pattern' => '^\+?[0-9]{9-10}', 'name' => 'telefoon', 'id' => 'telefoon', 'value' => $persoon->telefoon, 'class' => 'form-control', 'placeholder' => 'Telefoon')); ?>
</div>

<div class="form-group">
    <label for="email" class="control-label">Email</label>
    <?php echo form_input(array('data-toggle' => "tooltip", 'title' => "Geef je email adres op", 'data-error' => 'This email address is invalid', 'type' => 'email', 'name' => 'email', 'id' => 'email', 'value' => $persoon->email, 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required', 'data-error' => 'Dit is geen correct email adres.')); ?>
    <div class="help-block with-errors"></div>

</div>
<div class="alert alert-danger" id="labelEmail">
    Dit email adres is al in gebruik!
</div>

<div class="form-group">
    <label for="wachtwoord" class="control-label">Wachtwoord</label>
    <div class="form-inline row">
        <div class="form-group col-sm-12">
            <input data-toggle="tooltip" title="Geef een wachtwoord op" type="password" data-minlength="6" class="form-control" id="een" placeholder="Wachtwoord" name="wachtwoord"required>
            <div class="help-block">Minimum 6 karakters.</div>
        </div>
        <div class="form-group col-sm-12">
            <input data-toggle="tooltip" title="Herhaal je wachtwoord"type="password" class="form-control" id="wachtwoord" data-match="#een" data-match-error="Deze wachtwoorden komen niet overeen!" placeholder="Herhaal wachtwoord" required>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</div>


<div class="form-group">
    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $persoon->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>


    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-secondary">Annuleren</p>'); ?>
    <button type="submit" data-id="' . $persoon->id . '" class="btn btn-primary">Opslaan</button>
    <?php
    echo form_close();
    ?>
</div>

