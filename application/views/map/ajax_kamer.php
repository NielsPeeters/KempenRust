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
        <label for="naam" class="control-label">Naam</label>
        <?php echo form_input(array('type'=>'text','name' => 'naam', 'id' => 'naam', 'value' => $kamer->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required'));?>
    </div>
    </br>

    <div class="form-group">
        <label for="aantalpersonen" class="control-label">Maximum aantal personen</label>
        <?php echo form_input(array('type' => 'number', 'name' => 'aantalpersonen', 'id' => 'aantalpersonen', 'value' => $kamer->aantalPersonen, 'class' => 'form-control', 'placeholder' => 'Aantalpersonen', 'required' => 'required'));?>
        </br>
    </div>

    <div class="form-group">
        <label for="beschikbaar" class="control-label">Beschikbaarheid</label>
        <?php 
        if($kamer->beschikbaar==1){
            echo "<div><input type='radio' name='beschikbaar' id='beschikbaar' value='1' checked>Beschikbaar";
            echo "</div><div><input type='radio' name='beschikbaar' id='beschikbaar' value='0' >Niet beschikbaar</div>";}
        else{
            echo "<div><input type='radio' name='beschikbaar' id='beschikbaar' value='1' >Beschikbaar";
            echo "</div><div><input type='radio' name='beschikbaar' id='beschikbaar' value='0' checked>Niet beschikbaar</div>";}?>
    </div>
    </br>

    <div class="form-group">
        <label for="kamertype" class="control-label">Kamer type</label>
        <select name="kamertype" class="form-control">
        <?php
            $value = $kamer->kamerTypeId;
            foreach ($kamertypes as $kamertype) {
                $type = $kamertype->id; ?>
                <option value=<?php echo $type; ?> <?php echo set_select('kamertype', $type, $type === $value);?>>
                <?php echo $kamertype->omschrijving;?>
                </option>
            <?php }?>
        </select>  
    </div>  
    </br>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $kamer->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    

    <button type="submit" data-id="' . $kamer->id . '" class="btn opslaan">Opslaan</button>
    <button type="button" data-id="' . $kamer->id . '" class="btn verwijder">Verwijderen</button>
    <button type="reset" data-id="' . $kamer->id . '" class="btn reset">Annuleren</button>
</div>
</form>