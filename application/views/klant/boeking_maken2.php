<script>
/**
* \file
*/
        function voegKamerToe() 
        {
            /**
            * opent een form om een kamer aan de boeking toe te voegen
            */
          $.ajax({type : "GET",
            url : site_url + "/klant/nieuweKamer",
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan toevoegen hangen als die er is
                attach_click();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function attach_click() {
          $(".voegtoe").click(function (e) {
              /**
              *Bij het klikken op toevoegen, wordt de kamer toegevoegd
              */
            e.preventDefault();
            var id = $(this).data('id');
          });

          $(".annuleren").click(function(){
            $("#panel").hide();
          });
        }

    $(document).ready(function(){
        $("#panel").hide();

        $("#toevoegen").click(function() {
            /**
            *Bij het klikken op de knop om een kamer toe te voegen, wordt de functie om een kamer toe te voegen uitgevoerd
            */
            voegKamerToe();
        });
    });
</script>

<div class="row">
    <h4>Kamer(s) kiezen</h4>
    <p>Voeg een kamer toe: <button class="btn btn-primary" id="toevoegen">Voeg toe</button></p>
    
    <div class="panel panel-default" id="panel">
        <!--<div class="panel-heading">Details</div>-->
        <div class="panel-body">
         
            <div id="resultaat"></div>
        
        </div>
    </div>
    
    <h4>Opmerkingen</h4>
    <p>Typ hieronder eventuele opmerkingen in verband met uw boeking. Bv. als u een hond bij u zich heeft of allergiën heeft.</p>
    
</div>

<?php echo "</tbody></table>";?>

<p>
  <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>

