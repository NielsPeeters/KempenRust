<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script>
    function haalKamers(typeId) {  
        var options = '';
        
        <?php 
            foreach($kamers as $id => $info){
                $delen = explode(".", $info);
        ?>
                if(typeId == <?php echo $delen[0];?>){
                    options = options + '<option value="<?php echo $id;?>"><?php echo $delen[1];?></option>';
                }
        <?php
            }
        ?>
        
        $('#kamer').html(options);
    }
    
    $(document).ready(function(){
        $("#voorkeur").hide();

        $("#ja").click(function() {
            $("#voorkeur").show();
        });
        
        $("#nee").click(function(){
            $("#voorkeur").hide();
        });
        
        $("#kamertype").change(function(){
            var id = $(this).val();
            haalKamers(id);
        });
    });
</script>

<div id="inhoud">
<?php
echo javascript("validator.js");
$attributes = array('name' => 'myform', 'data-toggle'=>'validator', 'id' => 'myform', 'role'=>'form', 'method' => 'post');
echo form_open('klant/voegKamerToe', $attributes);
?>

    <div class="form-group">
        <p>Kies het aantal personen voor deze kamer:</p>
        <?php foreach($persoontypes as $persoon) {
            echo form_label($persoon->soort . ':', 'persoon' . $persoon->id);
            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo form_input(array('type' => 'number', 'name' => 'persoon' . $persoon->id, 'id' => 'persoon' . $persoon->id, 'required' => 'required', 'value' => '0'));
            echo "<p>&nbsp;</p>";
            echo "\n";
        }?>
    </div>

    <div class="form-group">
        <p>Welke soort kamer wenst u?</p>
        <?php $optionsKamertypes = array();
        
            foreach($kamertypes as $id => $naam) {
                $optionsKamertypes[$id] = $naam;
            }
        
            echo form_dropdown('kamertype', $optionsKamertypes, '0', 'id="kamertype" size="10" class="form-control" required = "required"');
        ?>
    </div>

    <div class="form-group">
        <p>Heeft u een voorkeur voor een specifieke kamer?</p>
        <?php 
            echo form_radio('voorkeur', 'ja', '', 'id="ja"') . form_label('Ja', 'ja');
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo form_radio('voorkeur', 'nee', '', 'id="nee"') . form_label('Nee', 'nee');
        ?>
    </div>

    <div class="form-group" id="voorkeur">
        <p>Kies een specifieke kamer:</p>
        <?php echo form_dropdown('kamer', array(), '0', 'id="kamer" size="10" class="form-control"'); ?>
    </div>

    <div class="help-block with-errors"></div>
    
    <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <?php echo form_submit('submit', 'Toevoegen', 'class="btn btn-primary"');?>
<?php echo form_close();?>
</div>