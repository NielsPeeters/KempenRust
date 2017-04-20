<script>
    $(document).on('click', function (e) {

    });
</script>

<div class="col-sm-6 col-lg-6">
    <?php // iedereen
    echo  image("logo.PNG",'class="navbar-brand-img"');
    ?>
    <ul>
        <li><?php echo $boeking->persoon->naam . " " . $boeking->persoon->voornaam; ?></li>
        <li><?php echo $boeking->persoon->straat . " " . $boeking->persoon->huisnummer . " " . $boeking->persoon->bus; ?></li>
        <li><?php echo $boeking->persoon->postcode . " " . $boeking->persoon->gemeente; ?></li>
        <li><?php echo $boeking->persoon->telefoon; ?></li>
        <li><?php echo $boeking->persoon->email; ?></li>
    </ul>
</div>

<div class="col-sm-6 col-lg-6">
    <ul>
        <li>Geelsebaan 51-53</li>
        <li>2460 Kasterlee</li>
        <li>+32/14.85.04.53</li>
        <li>+32/14.85.33.26</li>
        <li><?php echo anchor('http://www.kempenrust.be')?></li>
    </ul>
</div>


<div class="col-sm-12 col-lg-12">
<h2 >Factuur</h2>
    <ul>
        <li><strong>Factuurnummer: </strong><?php echo $factuur->id; ?></li>
        <li><strong>Factuurdatum: </strong><?php echo toDDMMYYYY($factuur->datumFactuur); ?></li>
    </ul>
</div>

<table class="col-sm-12 col-lg-12">
    <tr>
        <th class="col-sm-3 col-lg-3">Omschijving</th><th class="col-sm-3 col-lg-3">Aantal</th><th class="col-sm-3 col-lg-3">Prijs</th><th class="col-sm-3 col-lg-3">Totaal</th>
    </tr>
</table>

<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'data-toggle' => 'validator', 'role' => 'form');
echo form_open('factuur/schrijfFactuur', $attributes);
?>

<div class="form-group">
    <label for="persoon" class="control-label">Gast</label>
    <?php if (!$boeking->persoonId == 0) {
        $naam = $boeking->persoon->naam . " " . $boeking->persoon->voornaam;
        echo form_input(array('disabled' => 'disabled', 'name' => 'persoon', 'id' => 'persoon', 'value' => $naam, 'class' => 'form-control', 'placeholder' => 'Gast', 'required' => 'required'));
    } else {
        echo "TODO: gast selecteren of nieuwe gast maken";
    } ?>
    </br>
</div>

<div class="form-group">
    <label for="arrangement" class="control-label">Arrangement</label>
    <select id="dropDown" name="arrangement" class="form-control">
        <?php
        $value = $boeking->arrangementId; ?>
        <option value="Geen arrangement">Geen arrangement</option><?php
        foreach ($arrangementen as $arrangement) {
            $type = $arrangement->id; ?>
            <option value="<?php echo $arrangement->omschrijving; ?>" <?php echo set_select('arrangement', $type, $type === $value); ?>>
                <?php echo "$arrangement->naam"; ?>
            </option>

        <?php } ?>
    </select>
    <p class="bg-info" id="arrangementOmschrijving"></p>
</div>


<div class="form-group" id="dropDownPension">
    <label for="pension" class="control-label">Pension</label>
    <?php
    $arrangementId = $boeking->arrangementId;
    foreach ($arrangementen as $arrangement) {
        if ($arrangementId == $arrangement->id) {
            $pensionId = $arrangement->pensionId;
        }
    }
    ?>
    <select name="pension" class="form-control"><?php
        foreach ($pensions as $pension) {
            $type = $pension->id; ?>
            <option value="<?php echo $pension->naam; ?>" <?php echo set_select('pension', $type, $type === $pensionId); ?>>
                <?php echo "$pension->naam"; ?>
            </option>
        <?php } ?>
    </select>

</div>
<p id="datum1"><?php echo $boeking->startDatum; ?></p>
</br>

<div class="form-group row">
    <div class="col-xs-6">
        <label for="from" class="control-label ">Van</label>
        <input type="text" class="form-control" id="from" name="startDatum"
               value=<?php echo $boeking->startDatum; ?> required>
    </div>
    <div class="col-xs-6">
        <label for="to" class="control-label">Tot</label>
        <input class="form-control" type="text" id="to" name="eindDatum"
               value=<?php echo $boeking->eindDatum; ?> required>
    </div>
</div>


<div class="form-group" id="dropDownPension">
    <label for="kamerBoeking" class="control-label" data-toggle="tooltip"
           title="Selecteer meerdere kamers door de CTRL toets ingedrukt te houden.">Geboekte kamers</label>
    <select size="1" class="selectpicker form-control" name="kamerBoeking" multiple>
        <?php
        foreach ($kamers as $kamer) {
            $rij = array();
            foreach ($kamerBoekingen as $kamerBoeking) {
                array_push($rij, $kamerBoeking->kamerId);
            }
            if (in_array($kamer->id, $rij)) {
                ?>
                <option selected><?php echo $kamer->naam . " " . $kamer->type->omschrijving; ?></option>
                <?php

            } else {
                ?>
                <option><?php echo $kamer->naam . " " . $kamer->type->omschrijving; ?></option>
                <?php
            }

        }
        ?>
    </select>
</div>


<div class="form-group row">
    <?php $totaal = 0;
    foreach ($typePersonen as $typePersoon) {
        //echo $typePersoon->id;
        //echo "test typepersoon </br>";
        foreach ($boekingTypePersonen as $boekingTypePersoon) {
            //echo $boekingTypePersoon->typePersoonId;
            //echo "test boekingtypepersoon </br>";

            if ($boekingTypePersoon->typePersoonId == $typePersoon->id) {
                //echo "test ze zijn gelijk";
                $totaal += $boekingTypePersoon->aantal; ?>
                <div class="col-xs-3">
                <label for="typePersoon" id="typePersoon"
                       class="control-label"><?php echo $typePersoon->soort; ?></label>
                <input class="form-control" type="number" id="to" name="to"
                       value="<?php echo $boekingTypePersoon->aantal; ?>" required>
                </div><?php
            }
        }
    }
    ?>
</div>
</br>
<div class="form-group" id="totaal">
    <label for="aantalMensen" class="control-label">Totaal aantal personen</label>
    <input class="form-control" type="number" id="" name="to" value="<?php echo $totaal; ?>" disabled>
</div>

<div class="form-group">
    <label for="opmerking" class="control-label">Opmerkingen</label>
    <textarea rows="3" class="form-control" name="opmerking"><?php echo $boeking->opmerking; ?></textarea>
</div>

<div class="form-group">
    <label for="goedgekeurd" class="control-label">Goedgekeurd</label>
    <?php
    if ($boeking->goedgekeurd == '1') {
        echo "<div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='1' checked>Ja";
        echo "</div><div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='0' >Nee</div>";
    } else {
        echo "<div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='1' >Ja";
        echo "</div><div><input type='radio' name='goedgekeurd' id='goedgekeurd' value='0' checked>Nee</div>";
    } ?>
</div>
</br>


<?php echo form_input(array('type' => 'hidden', 'name' => 'id', 'id' => 'id', 'value' => $boeking->id, 'class' => 'form-control', 'placeholder' => 'id')) ?>

<div class="help-block with-errors"></div>

<button type="button" class="btn btn-secondary annuleren">Annuleren</button>
<button type="button" data-id="' . $boeking->id . '" class="btn btn-warning verwijder">Verwijderen</button>
<button type="submit" data-id="' . $boeking->id . '" class="btn btn-primary opslaan">Opslaan</button>

</div>
</form>