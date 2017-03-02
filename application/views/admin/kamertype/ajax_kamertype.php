<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script>
 $(document).ready(function(){
    $('.pause').click(function(e){
        $('#myForm').validator();
    });
 });


</script>
<?php echo javascript("validator.js");
//$attributes = array('name' => 'myform','id'=>'JqAjaxForm');
//echo form_open('kamer/schrijfJSONObject', $attributes);
?>

<form name='myform' id='JqAjaxForm'>
    <div class="form-group">
        <label for="omschrijving" class="control-label">Omschrijving</label>
        <?php echo form_input(array('type'=>'text','name' => 'omschrijving', 'id' => 'omschrijving', 'value' => $type->omschrijving, 'class' => 'form-control', 'placeholder' => 'Omschrijving', 'required' => 'required'));?>
    </div>
    </br>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $type->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    

    <button type="submit" data-id="' . $kamer->id . '" class="btn opslaan">Opslaan</button>
    <button type="button" data-id="' . $kamer->id . '" class="btn verwijder">Verwijderen</button>
    <button type="reset" data-id="' . $kamer->id . '" class="btn reset">Annuleren</button>
</div>
</form>