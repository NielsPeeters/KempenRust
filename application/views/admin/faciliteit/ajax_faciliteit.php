<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script>
 $(document).ready(function(){
    $('.opslaan').click(function(e){
        /**
        *Bij een klik op de opslaan knop wordt het form gevalideert.
        */
        $('#myForm').validator();
    });
 });


</script>
<?php echo javascript("validator.js");?>

<form name='myform' id='JqAjaxForm'>
    <div class="form-group">
        <label for="naam" class="control-label">Naam</label>
        <?php echo form_input(array('type'=>'text','name' => 'naam', 'id' => 'naam', 'value' => $kamer->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required'));?>
    </div>
    </br>
    
    <div class="form-group">
        <label for="prijs" class="control-label">Prijs</label>
        <?php echo form_input(array('type'=>'text','name' => 'prijs', 'id' => 'prijs', 'value' => $kamer->prijs, 'class' => 'form-control', 'placeholder' => 'Prijs', 'required' => 'required'));?>
    </div>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $kamer->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    
    <?php echo anchor('/home/index', '<p  id="annuleren" class="btn btn-secondary">Annuleren</p>'); ?>
    <button type="button" data-id="' . $kamer->id . '" class="btn btn-warning verwijder">Verwijderen</button>
   
    <button type="submit" data-id="' . $kamer->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>

