
<script>
/**
* \file
*/
        function haalFaciliteit (faciliteitId) 
        {
            /**
            * haalt het kamer object op dat behoort tot het meegegeven id
            * \param kamerId het id van de geselecteerde kamer
            * de geselecteerde kamer wordt weergeven in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/faciliteit/haalFaciliteit",
            data : { faciliteitId : faciliteitId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen kamer mee
                resultaat = $(result).find("#id").attr("value");
                $("#kamerId").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function verwijderFaciliteit(id) 
        {
            /**
            * Verwijderd te kamer die behoort tot het meegegeven id
            * \param id het id van de te verwijderen kamer als int
            * een leeg kamer object genereren als de kamer verwijderd kan worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/faciliteit/verwijderFaciliteit",
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

        function schrijfFaciliteit()
        {
            /**
            * Update of insert een kamerobject
            * \param id het id van de te verwijderen kamer als int
            */
            var dataString = $("#JqAjaxForm").serialize();
            console.log(dataString) 
            $.ajax({type: "POST",
                url: site_url + "/faciliteit/schrijfFaciliteit",
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
              *Bij het klikken op opslaan wordt het kamer object opgeslagen
              */
            schrijfFaciliteit();
        })
        }

    $(document).ready(function(){
        $("#panel").hide();

        $("#faciliteit").change(function() {
            /**
            *Bij het veranderen van de geselecteerde kamer, veranderdt de info in het panel
            */
            haalFaciliteit($(this).val());
        });

        $(".delete").click(function (e) {
            /**
            *Bij het klikken op verwijder wordt het kamer object verwijderdt
            */
            e.preventDefault();
            var id = $("#faciliteitId").html();
            verwijderFaciliteit(id);
        });

        $("#nieuw").click(function (){
            /**
            *Bij het klikken op nieuw wordt een nieuw kamer object opgehaald
            */
            haalFaciliteit(-1);
        });
    });
</script>


<?php 
$options = array();
foreach($types as $type){
	$options[$type->id] ="$type->naam";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('faciliteit', $options, '0', 'id="faciliteit" size="10" class="form-control"');?>
        </p>
        </div>
        <p  id="nieuw" class="btn btn-primary">Nieuw</p>
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
                      Weet je zeker dat je deze faciliteit wil verwijderen?
                  </p>
                  <p hidden id="kamerId">
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
                      Je kan deze faciliteit niet verwijderen omdat er nog boekingen aan verbonden zijn.
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