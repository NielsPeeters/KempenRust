<script>
/**
* \file
*/
    function haalBoeking(boekingId) 
    {
            /**
            * haalt het boeking object op dat behoort tot het meegegeven id
            * \param boekingId het id van de geselecteerde boeking
            * de geselecteerde boeking wordt weergeven in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/klant/haalBoeking",
            data : { boekingId : boekingId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen kamer mee
                resultaat = $(result).find("#id").attr("value");
                $("#boekingId").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
    }

    function verwijderBoeking(id) 
    {
            /**
            * Verwijdert de boeking die behoort tot het meegegeven id
            * \param id het id van de te verwijderen boeking als int
            * een leeg boeking object genereren
            */
            $.ajax({type: "GET",
                url: site_url + "/klant/verwijderBoeking",
                data: {id: id},
                dataType: "json",
                success: function (result) {
                    if(result==0){
                        location.reload();
                    } else {
                        $('#verwijderFout').model('show');
                    }
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText + "\n" + status + "\n" + error);
                }
            });
    }

    function attach_click() {
          $(".verwijder").click(function (e) {
              /**
              *Bij het klikken op verwijder wordt het verwijder modal getoont
              */
            e.preventDefault();
            var id = $(this).data('id');
            $('#verwijderModal').modal('show');
          });

          $(".annuleren").click(function(){
            $("#panel").hide();
          });
    }

    $(document).ready(function(){
        $("#panel").hide();

        $("#boeking").change(function() {
            /**
            *Bij het veranderen van de geselecteerde boeking, verandert de info in het panel
            */
            haalBoeking($(this).val());
        });

        $(".delete").click(function (e) {
            /**
            *Bij het klikken op verwijder wordt het menu object verwijderd
            */
            e.preventDefault();
            var id = $("#id").val();
            verwijderBoeking(id);
        });
    });
</script>
<style>
    #nieuweBoeking {
        color: white;
    }
</style>

<?php 
$options = array();
foreach($boekingen as $boeking){
	$options[$boeking->id] = toDDMMYYYY($boeking->startDatum) . " - " . toDDMMYYYY($boeking->eindDatum) . ": ";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('boeking', $options, '0', 'id="boeking" size="10" class="form-control"');?>
        </p>
        </div>
        <button type="button" class="btn btn-primary annuleren"><?php echo anchor('klant/index', 'Nieuw', 'id="nieuweBoeking"');?></button>
        </br></br>
    </div>

  <div class="col-lg-8">
    <div class="panel panel-default" id="panel">
        <!--<div class="panel-heading">Details</div>-->
        <div class="panel-body">       
            <div id="resultaat"></div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="verwijderModal" role="dialog">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Waarschuwing</h4>
              </div>
              <div class="modal-body">
                  <p>
                      Weet je zeker dat je deze boeking wil annuleren? Dit betekent dat deze boeking verwijderd zal worden!
                  </p>
                  <p hidden id="boekingId">
                  </p>
              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn btn-warning delete" id="id">Verwijderen</button>
                  <button type="button" data-dismiss="modal" class="btn">Annuleren</button>
              </div>
              
          </div>
      </div>

  </div>

    <div class="modal fade" id="verwijderFout" role="dialog">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Waarschuwing</h4>
              </div>
              <div class="modal-body">
                  <p>
                      Je kunt deze boeking niet verwijderen!
                  </p>
                
                  </p>
              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn">Oke</button>
              </div>
              
          </div>
      </div>

  </div>

<?php echo "</tbody></table>";?>

<p>
  <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>