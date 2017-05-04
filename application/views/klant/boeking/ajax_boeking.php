<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<div>
    <table class="table table-responsive " id="boekingen">
        <tr class="success">
            <th>Naam</th>
            <th>Van / Tot</th>
            <th>Arrangement</th>
            <th>Tijdstip</th>
            <th>Goedgekeurd?</th>
        </tr>
        <tr>
            <td><?php echo $boeking->persoon->naam . " " . $boeking->persoon->voornaam; ?></td>
            <td><?php echo toDDMMYYYY($boeking->startDatum); ?></td>
            <td><?php echo $boeking->arrangement;?></td>
            <td><?php echo toDDMMYYYY($boeking->tijdstip);?></td>
            <td class="text-center">
            <?php 
                if($boeking->goedgekeurd==1){
                    echo '<button type="button"' . "id= $boeking->id" .' class="btn btn-success btn-xs btn-round"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
                }
                else{
                    echo '<button type="button"' . "id= $boeking->id" .' class="btn btn-danger btn-xs btn-round"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
                }
            ?>
            </td>
            <td  class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-warning btn-xs btn-round wijzig"><span class="glyphicon glyphicon-pencil"></span></button></td>
            <td  class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijder"><span class="glyphicon glyphicon-remove"></span></button></td>
        </tr>
        <tr>
            <td><?php echo $boeking->persoon->email;?> </td>
            <td><?php echo toDDMMYYYY($boeking->eindDatum); ?></td>
            <td>
                <?php 
                    $aantal="persoon"; 
                
                    if($boeking->aantalPersonen>1){
                        $aantal="personen";
                    } 
                    
                    echo "$boeking->aantalPersonen $aantal"; 
                ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </hr>
    </table>
</div>
    
<button type="button" class="btn btn-secondary annuleren">Annuleren</button>
<button type="button" data-id="' . $boeking->id . '" class="btn btn-warning verwijder">Verwijderen</button>