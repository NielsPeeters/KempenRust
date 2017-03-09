<script>
/**
* \file
*/
        function haalboeking (boekingId) 
        {
            /**
            * haalt het boeking object op dat behoort tot het meegegeven id
            * \param boekingId het id van de geselecteerde boeking
            * de geselecteerde boeking wordt weergeven in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/boeking/haalboeking",
            data : { boekingId : boekingId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen boeking mee
                resultaat = $(result).find("#id").attr("value");
                $("#boekingId").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function verwijderboeking(id) 
        {
            /**
            * Verwijderd te boeking die behoort tot het meegegeven id
            * \param id het id van de te verwijderen boeking als int
            * een leeg boeking object genereren als de boeking verwijderd kan worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/boeking/verwijderboeking",
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

        function schrijfboeking()
        {
            /**
            * Update of insert een boekingobject
            * \param id het id van de te verwijderen boeking als int
            */
            var dataString = $("#JqAjaxForm").serialize();
            console.log(dataString) 
            $.ajax({type: "POST",
                url: site_url + "/boeking/schrijfboeking",
                data: dataString,
                dataType: "json",
                success: function (result) {
                    //location.reload();
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

          $(".opslaan").click(function(){
            /**
              *Bij het klikken op opslaan wordt het boeking object opgeslagen
              */
            schrijfboeking();
        })
        }

    $(document).ready(function(){
        $("#panel").hide();

        $("#boeking").change(function() {
            /**
            *Bij het veranderen van de geselecteerde boeking, veranderdt de info in het panel
            */
            haalboeking($(this).val());
        });

        $(".delete").click(function (e) {
            /**
            *Bij het klikken op verwijder wordt het boeking object verwijderdt
            */
            e.preventDefault();
            var id = $("#boekingId").html();
            verwijderboeking(id);
        });

        $("#nieuw").click(function (){
            /**
            *Bij het klikken op nieuw wordt een nieuw boeking object opgehaald
            */
            haalboeking(-1);
        });
    });
</script>


<?php 
$options = array();
foreach($boekingen as $boeking){
    $naam = $boeking->persoon->naam ." ". $boeking->persoon->voornaam." | " . $boeking->arrangement . " | ". $boeking->startDatum 
    . " tot ". $boeking->eindDatum ;
	$options[$boeking->id] = $naam;
}
?>


<div class="row">
    <div  class="col-lg-5" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('boeking', $options, '0', 'id="boeking" size="10" class="form-control"');?>
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
                      Weet je zeker dat je deze boeking wil verwijderen?
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
                      Je kan deze boeking niet verwijderen omdat er nog boekingen aan verbonden zijn.
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
