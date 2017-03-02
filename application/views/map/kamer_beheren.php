<script>
/**
* \file
*/
        function haalKamer (kamerId) 
        {
            /**
            * \file
            * haalt het kamer object op dat behoort tot het meegegeven id
            * \param kamerId het id van de geselecteerde kamer
            * \return de geselecteerde kamer in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/kamer/haalKamer",
            data : { kamerId : kamerId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen kamer mee
                resultaat = $(result).find("#id").attr("value");
                $("#kamerid").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function verwijderKamer(id) 
        {
            /**
            * Verwijderd te kamer die behoort tot het meegegeven id
            * \param id het id van de te verwijderen kamer als int
            * \return een leeg kamer object als de kamer verwijderd kon worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/kamer/verwijderKamer",
                data: {id: id},
                dataType: "json",
                success: function (result) {
                    if(result==0){
                        location.reload();
                    }
                    else{
                        $("#verwijderfout").modal('show');
                    }
                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }

        function schrijfKamer()
        {
            /**
            * Update of insert een kamerobject
            * \param id het id van de te verwijderen kamer als int
            * \return een melding dat de gegevens succesvol zijn opgeslagen
            */
            var dataString = $("#JqAjaxForm").serialize();
            console.log(dataString) 
            $.ajax({type: "POST",
                url: site_url + "/kamer/schrijfJSONObject",
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
          $("#opslaan").click(function (e) {
            e.preventDefault();
            schrijfKamer();
          });

          $(".verwijder").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#verwijderModal').modal('show');
          });

          $(".opslaan").click(function(e){
            
            schrijfKamer();
        })
        }

    $(document).ready(function(){
        $("#panel").hide();

        $("#kamer").change(function() {
            haalKamer($(this).val());
        });

        $(".delete").click(function (e) {
            e.preventDefault();
            var id = $("#kamerid").html();
            verwijderKamer(id);
        });

        $("#nieuw").click(function (e){
            haalKamer(-1);
        });
    });
</script>


<?php 
$options = array();
foreach($kamers as $kamer){
	$options[$kamer->id] ="$kamer->naam";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('kamer', $options, '0', 'id="kamer" size="10" class="form-control"');?>
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
                      Weet je zeker dat je deze kamer wil verwijderen?
                  </p>
                  <p hidden id="kamerid">
                  </p>
              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn btn-warning delete" id="id">Verwijderen</button>
                  <button type="button" data-dismiss="modal" class="btn">Annuleren</button>
              </div>
              
          </div>
      </div>

  </div>

    <div class="modal fade" id="verwijderfout" role="dialog">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Waarschuwing</h4>
              </div>
              <div class="modal-body">
                  <p>
                      Je kan deze kamer niet verwijderen omdat er nog boekingen aan verbonden zijn.
                  </p>
                
                  </p>
              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn">Oke</button>
              </div>
              
          </div>
      </div>

  </div>

<?php

echo "</tbody></table>";




?>


<p>
  <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>
