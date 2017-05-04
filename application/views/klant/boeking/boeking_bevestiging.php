<div class="row">
    <h4>Overzicht boeking</h4>
    <p>Vanaf: <?php echo toDDMMYYYY($begindatum);?> tot: <?php echo toDDMMYYYY($einddatum);?></p>
    
    <?php 
        if(isset($pension)) {
    ?>      
            <p>Pension: <?php echo $pension->naam;?></p>
    <?php       
        } else {
    ?>
            <p>Arrangement: <?php echo $arrangement->naam;?></p>
    <?php      
        }
    ?>
            
    <p>Geboekte kamers:</p>
    <ul>
        <?php
            foreach($kamers as $id => $info){
                $delen = explode('.', $info);
        ?>
                <li><?php echo $delen[1] . '(' . $delen[2]. ')';?></li>
        <?php
            }
        ?>
    </ul>
    <p>Opmerking: <?php echo $this->session->userdata('opmerking');?></p>
    <p>Totale prijs (exclusief consumpties): <?php echo '€' . toKomma($prijs);?></p>
    <p>Te betalen voorschot (via overschrijving): €20</p>
    
    <h4>Overzicht rekening Hotel Kempenrust</h4>
    <p>IBAN: BE230 026 631 772</p>
    <p>BIC/SWIFT: GEBABEBB</p>
    <p>Bank: BNP Paribas Fortis</p>
</div>

<?php echo "</tbody></table>";?>

<p>
  <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>