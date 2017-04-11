
<?php
$aantal=count($kamerBoekingen);
if($aantal>0){ 
?>

<div class="form-group" id="geboekteKamers"> <!--kamers-->
        <label for="kamerBoeking"  class="control-label">Geboekte kamers</label>
         <table class="table table-condensed">
         <tr class="success">
            <th >Kamer</th>
            <th >Type</th>
            <th >Aantal personen</th>
            <th>Verwijder</th>
         </tr>
        <?php
        foreach($kamers as $kamer){
            $teller=0;
            $rij =  array();
            foreach($kamerBoekingen as $kamerBoeking){
                array_push($rij,$kamerBoeking->kamerId);
            }
                if(in_array($kamer->id, $rij) ){
                     ?>
                     <tr>
                        <td><?php echo $kamer->naam; ?></td>
                        <td><?php echo $kamer->type->omschrijving; ?></td>
                        <td><?php echo $kamerBoeking->aantalMensen;?> </td>
                        <td><button type="button" id="<?php echo $kamerBoeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijderkamer"><span class="glyphicon glyphicon-remove"></span></button></td>
                     </tr>
                    <?php
                
                }
            }
            ?>
        </table>

    </div>  

<?php } 
else {
    echo "<p>Er zijn geen kamers gekozen </p>";
}