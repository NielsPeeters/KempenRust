<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('prijs/schrijfPrijs', $attributes);

foreach ($prijzen as $prijs){
?>
    <div class="form-group">
        <?php if($prijs->meerderePersonen == 1){ ?>
            <label for="<?php echo $prijs->id;?>" class="control-label">Single prijs</label>
        <?php } else { ?>
            <label for="<?php echo $prijs->id;?>" class="control-label">Double prijs</label>
        <?php } ?>
        <?php echo form_input(array('data-match'=>'','type'=>'text','name' => 'prijs','id' => "' . $prijs->id; . '", 'value' => $prijs->actuelePrijs, 'class' => 'form-control', 'placeholder' => '0,00', 'required' => 'required'));?>
    </div>
    </br>
<?php } ?>




    <div class="help-block with-errors"></div>
    
    
    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="submit" data-id="' . $prijs->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>