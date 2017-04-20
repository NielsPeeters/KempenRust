<script>
        function haalFactuur (factuurId)
        {
            /**
            * haalt het factuur object op dat behoort tot het meegegeven id
            * \param factuurId het id van de geselecteerde factuur
            * de geselecteerde factuur wordt weergeven in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/factuur/haalFactuur",
            data : { factuurId : factuurId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen boeking mee
                resultaat = $(result).find("#id").attr("value");
                $("#factuurId").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }


        function verwijderFactuur(id)
        {
            /**
            * Verwijderd de factuur die behoort tot het meegegeven id
            * \param id het id van de te verwijderen factuur als int
            * een leeg factuur object genereren als de factuur verwijderd kan worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/factuur/verwijderFactuur",
                data: {id: id},
                dataType: "json",
                success: function (result) {
                    if(result==0){
                        location.reload();
                    }
                    else{
                        $("#verwijderFout").modal('show');
                    }
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
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

        $("#factuur").change(function() {
            /**
            *Bij het veranderen van de geselecteerde factuur, veranderdt de info in het panel
            */
            haalFactuur($(this).val());
        });

        $(".delete").click(function (e) {
            /**
            *Bij het klikken op verwijder wordt het factuur object verwijderdt
            */
            e.preventDefault();
            var id = $("#factuurId").html();
            verwijderFactuur(id);
        });

        $("#nieuw").click(function (){
            /**
            *Bij het klikken op nieuw wordt een nieuw factuur object opgehaald
            */
            haalFactuur(-1);
        });

    });
</script>


<?php 
$options = array();
foreach($facturen as $factuur){
    $naam = $factuur->boeking->persoon->naam ." ". $factuur->boeking->persoon->voornaam." | " . toDDMMYYYY($factuur->boeking->startDatum)
    . " tot ". toDDMMYYYY($factuur->boeking->eindDatum) ;
	$options[$factuur->id] = $naam;
}
?>


<div class="row">
    <div  class="col-lg-5" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('factuur', $options, '0', 'id="factuur" size="10" class="form-control"');?>
        </p>
        </div>
        <p  id="nieuw" class="btn btn-primary">Nieuw</p>
        </br></br>
    </div>

  <div class="col-lg-7">
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
                      Weet je zeker dat je deze factuur wil verwijderen?
                  </p>
                  <p hidden id="factuurId">
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
                      Je kan deze factuur niet verwijderen omdat er nog boekingen aan verbonden zijn.
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
