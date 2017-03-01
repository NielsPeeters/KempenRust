<script>

    $(document).ready(function () {
        $('#label').hide();
        var emailVrij = "<?php echo $emailVrij; ?>";
        checkemailVrij(emailVrij);
    });

    function checkemailVrij(emailVrij) {
        if (emailVrij == 0) {
            $('#label').show();
            $("body, html").animate({scrollTop: $('#label').offset().top}, 600);
        }
    }

</script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform');
echo form_open('persoon/registreer', $attributes);
?>

<div class="form-group">
    <label for="naam" class="control-label">Naam</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'naam', 'id' => 'naam', 'value' => $persoon->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
    </br>
    <label for="voornaam" class="control-label">Voornaam</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'voornaam', 'id' => 'voornaam', 'value' => $persoon->voornaam, 'class' => 'form-control', 'placeholder' => 'Voornaam', 'required' => 'required')); ?>
    </br>
    <label for="gemeente" class="control-label">Gemeente</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'gemeente', 'id' => 'gemeente', 'value' => $persoon->gemeente, 'class' => 'form-control', 'placeholder' => 'Gemeente', 'required' => 'required')); ?>
    </br>
    <label for="postcode" class="control-label">Postcode</label>
    <?php echo form_input(array('title'=>'Een postcode bestaat uit 4 cijfers.','pattern'=>'[0-9]{4}', 'name' => 'postcode', 'id' => 'postcode', 'value' => $persoon->postcode, 'class' => 'form-control', 'placeholder' => 'Postcode', 'required' => 'required')); ?>
    </br>
    <label for="straat" class="control-label">Straat</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'straat', 'id' => 'straat', 'value' => $persoon->straat, 'class' => 'form-control', 'placeholder' => 'Straat', 'required' => 'required')); ?>
    </br>
    <label for="huisnummer" class="control-label">Huisnummer</label>
    <?php echo form_input(array('type' => 'number', 'name' => 'huisnummer', 'id' => 'huisnummer', 'value' => $persoon->huisnummer, 'class' => 'form-control', 'placeholder' => 'Huisnummer', 'required' => 'required')); ?>
    </br>
    <label for="bus" class="control-label">Bus</label>
    <?php echo form_input(array('name' => 'bus', 'id' => 'bus', 'value' => $persoon->bus, 'class' => 'form-control', 'placeholder' => 'Bus')); ?>
    </br>
    <label for="telefoon" class="control-label">Telefoon</label>
    <?php echo form_input(array('pattern' => '^\+?[0-9]{10}', 'name' => 'telefoon', 'id' => 'telefoon', 'value' => $persoon->telefoon, 'class' => 'form-control', 'placeholder' => 'Telefoon')); ?>
    </br>
    <label for="email" class="control-label">Email</label>
    <?php echo form_input(array('type'=>'email','name' => 'email', 'id' => 'email', 'value' => $persoon->email, 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required')); ?>
    </br>
    <div class="alert alert-danger" id="label">
        Dit email adres is al in gebruik!
    </div>
    <label for="wachtwoord" class="control-label">Wachtwoord</label>
    <?php echo form_input(array('type' => 'password', 'name' => 'wachtwoord', 'id' => 'wachtwoord','class' => 'form-control', 'placeholder' => 'Wachtwoord')); ?>
    </br>
    <label for="wachtwoord2" class="control-label">Wachtwoord herhalen</label>
    <?php echo form_input(array('type' => 'password', 'name' => 'wachtwoord2', 'id' => 'wachtwoord2', 'class' => 'form-control', 'placeholder' => 'Wachtwoord')); ?>
    </br>
    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $persoon->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>

    <button type="submit" data-id="' . $persoon->id . '" class="btn">Opslaan</button>
    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-warning">Annuleren</p>'); ?>

    <?php
        echo form_close();
    ?>
</div>

