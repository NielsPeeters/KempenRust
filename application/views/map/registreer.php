<script>

    $(document).ready(function () {
        $('#labelEmail').hide();
        var emailVrij = "<?php echo $emailVrij; ?>";
        checkemailVrij(emailVrij);
    });

    function checkemailVrij(emailVrij) {
        if (emailVrij === "0") {
            $('#labelEmail').show();
            $("body, html").animate({scrollTop: $('#labelEmail').offset().top}, 600);
        }
    
    }

</script>
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('persoon/registreer', $attributes);
?>




<div class="form-group">
    <label for="naam" class="control-label">Naam</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'naam', 'id' => 'naam', 'value' => $persoon->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="voornaam" class="control-label">Voornaam</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'voornaam', 'id' => 'voornaam', 'value' => $persoon->voornaam, 'class' => 'form-control', 'placeholder' => 'Voornaam', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="gemeente" class="control-label">Gemeente</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'gemeente', 'id' => 'gemeente', 'value' => $persoon->gemeente, 'class' => 'form-control', 'placeholder' => 'gemeente', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="postcode" class="control-label">Postcode</label>
    <?php echo form_input(array('title'=>' postcode bestaat uit 4 cijfers.','pattern'=>'[0-9]{4}', 'name' => 'postcode', 'id' => 'postcode', 'value' => $persoon->postcode, 'class' => 'form-control', 'placeholder' => 'Postcode', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="straat" class="control-label">Straat</label>
    <?php echo form_input(array('pattern'=>'[a-zA-Z]+','name' => 'straat', 'id' => 'straat', 'value' => $persoon->straat, 'class' => 'form-control', 'placeholder' => 'Straat', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="huisnummer" class="control-label">Huisnummer</label>
    <?php echo form_input(array('type' => 'number', 'name' => 'huisnummer', 'id' => 'huisnummer', 'value' => $persoon->huisnummer, 'class' => 'form-control', 'placeholder' => 'Huisnummer', 'required' => 'required')); ?>
</div>

<div class="form-group">
    <label for="bus" class="control-label">Bus</label>
    <?php echo form_input(array('name' => 'bus', 'id' => 'bus', 'value' => $persoon->bus, 'class' => 'form-control', 'placeholder' => 'Bus')); ?>
</div>

<div class="form-group">
    <label for="telefoon" class="control-label">Telefoon</label>
    <?php echo form_input(array('pattern' => '^\+?[0-9]{10}', 'name' => 'telefoon', 'id' => 'telefoon', 'value' => $persoon->telefoon, 'class' => 'form-control', 'placeholder' => 'Telefoon')); ?>
</div>

<div class="form-group">
    <label for="email" class="control-label">Email</label>
    <?php echo form_input(array('data-error'=>'This email address is invalid','type'=>'email','name' => 'email', 'id' => 'email', 'value' => $persoon->email, 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required', 'data-error'=>'Dit is geen correct email adres.')); ?>
    <div class="help-block with-errors"></div>
    
</div>
<div class="alert alert-danger" id="labelEmail">
        Dit email adres is al in gebruik!
</div>

<div class="form-group">
    <label for="wachtwoord" class="control-label">Wachtwoord</label>
    <div class="form-inline row">
      <div class="form-group col-sm-12">
        <input type="password" data-minlength="6" class="form-control" id="een" placeholder="Wachtwoord" required>
        <div class="help-block">Minimum 6 karakters.</div>
      </div>
      <div class="form-group col-sm-12">
        <input type="password" class="form-control" id="wachtwoord" data-match="#een" data-match-error="Deze wachtwoorden komen niet overeen!" placeholder="Herhaal wachtwoord" required>
        <div class="help-block with-errors"></div>
      </div>
    </div>
  </div>


<div class="form-group">
    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $persoon->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <button type="submit" data-id="' . $persoon->id . '" class="btn">Opslaan</button>
    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-warning">Annuleren</p>'); 
        echo form_close();
    ?>
</div>

