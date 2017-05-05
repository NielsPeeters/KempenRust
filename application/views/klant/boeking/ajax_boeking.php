<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<?php echo javascript("validator.js");?>

<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform','data-toggle'=>'validator','role'=>'form');
echo form_open('', $attributes);
?>
    <table class="table table-responsive " id="boekingen">
        <tr class="success">
            <th>Naam</th>
            <th>Van</th>
            <th>Tot</th>
            <th>Arrangement</th>
            <th>Gekozen kamer(s)</th>
            <th>Totaal aantal personen</th>
            <th>Goedgekeurd?</th>
        </tr>
        <tr>
            <td><?php echo toDDMMYYYY($boeking->startDatum); ?></td>
            <td><?php echo toDDMMYYYY($boeking->eindDatum); ?></td>
            <td><?php echo $boeking->arrangement->naam;?></td>
            <td>
                <?php
                    $teller = 0;
                
                    foreach($kamers as $id=>$kamer){
                        if($teller == 0) {
                            echo $kamer->naam . " (" . $kamer->kamerType->omschrijving . ")";
                        } else {
                            echo ", " . $kamer->naam . " (" . $kamer->kamerType->omschrijving . ")";
                        }
                    }
                ?>
            </td>
            <td>
                <?php 
                    $aantal="persoon"; 
                    
                    if($boeking->aantalPersonen>1){
                        $aantal="personen";
                    } 
                    
                    echo "$boeking->aantalPersonen $aantal" ; 
                ?>
            </td>
            <td class="text-center">
            <?php 
            if($boeking->goedgekeurd==1){
                echo '<button type="button"' . "id= $boeking->id" .' class="btn btn-success btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
            }
            else{
                echo '<button type="button"' . "id= $boeking->id" .' class="btn btn-danger btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
            }
            ?>
            </td>
        </tr>
    </table>


    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" data-id="' . $menu->id . '" class="btn btn-warning verwijder" id="annuleerBoeking">Annuleer boeking</button>
</form>