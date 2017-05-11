<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('prijs/schrijfPrijs', $attributes);

if (count($prijzen) > 0){

    foreach ($prijzen as $key => $prijs){
        ?>
        <div class="form-group">
            <?php if($prijs->meerderePersonen == 1){ ?>
                <label for="<?php echo $prijs->id;?>" class="control-label">Double prijs</label>
            <?php } else { ?>
                <label for="<?php echo $prijs->id;?>" class="control-label">Single prijs</label>

            <?php } ?>
            <?php echo form_input(array('data-match'=>'','type'=>'number', 'step' => '0.01','name' => "prijs$key",'id' => "prijs$key", 'value' => toKomma($prijs->actuelePrijs), 'class' => 'form-control', 'placeholder' => '0,00', 'required' => 'required'));?>
            <?php echo form_input(array('data-match'=>'','type'=>'hidden','name' => "id$key",'id' => "id$key", 'value' => $prijs->id, 'class' => 'form-control'));?>
        </div>
    <?php } ?>
    <button type="button" class="btn btn-secondary annuleren">Annuleren </button>
    <button type="submit" class="btn btn-primary opslaan">Opslaan</button>
<?php } else { ?>
    <div><h2>Gelieve alle informatie in te vullen.</h2></div>
    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
<?php

}
form_close();?>





