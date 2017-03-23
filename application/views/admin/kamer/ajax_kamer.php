<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('kamer/schrijfKamer', $attributes);
?>

    <div class="form-group">
        <label for="naam" class="control-label">Naam</label>
        <?php echo form_input(array('data-match'=>'','type'=>'text','name' => 'naam','id' => 'naam', 'value' => $kamer->naam, 'class' => 'form-control', 'placeholder' => 'Naam', 'required' => 'required'));?>
        
        
    </div>
    </br>

    <div class="form-group">
        <label for="aantalPersonen" class="control-label">Maximum aantal personen</label>
        <?php echo form_input(array('type' => 'number', 'name' => 'aantalPersonen', 'id' => 'aantalPersonen', 'value' => $kamer->aantalPersonen, 'class' => 'form-control', 'placeholder' => 'Max. aantal personen', 'required' => 'required'));?>
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
        <label for="kamerType" class="control-label">Kamer type</label>
        <select name="kamerType" class="form-control">
        <?php
            $value = $kamer->kamerTypeId;
            foreach ($kamerTypes as $kamerType) {
                $type = $kamerType->id; ?>
                <option value=<?php echo $type; ?> <?php echo set_select('kamerType', $type, $type === $value);?>>
                <?php echo $kamerType->omschrijving;?>
                </option>
            <?php }?>
        </select>  
    </div>  
    </br>

    <?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $kamer->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

    <div class="help-block with-errors"></div>
    
    
    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $kamer->id . '" class="btn btn-warning verwijder">Verwijderen</button>
    <button type="submit" data-id="' . $kamer->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>