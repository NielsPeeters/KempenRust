<script>
/**
* \file
*/
        function haalKamertype (kamerTypeId) 
        {
            /**
            * \file
            * haalt het kamertype object op dat behoort tot het meegegeven id
            * \param kamerTypeId het id van het geselecteerde kamertype
            * \return de geselecteerde kamertype in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/kamertype/haalKamertype",
            data : { kamerTypeId : kamerTypeId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen kamertype mee
                resultaat = $(result).find("#id").attr("value");
                $("#kamertypeid").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function verwijderKamertype(id) 
        {
            /**
            * Verwijderd het kamertype die behoort tot het meegegeven id
            * \param id het id van de te verwijderen kamertype als int
            * \return een leeg kamertype object als het kamertype verwijderd kon worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/kamertype/verwijderKamertype",
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

        function schrijfKamertype()
        {
            /**
            * Update of insert een kamertypeobject
            * \param id het id van het te verwijderen kamertype als int
            * \return een melding dat de gegevens succesvol zijn opgeslagen
            */
            var dataString = $("#JqAjaxForm").serialize();
            console.log(dataString) 
            $.ajax({type: "POST",
                url: site_url + "/kamertype/schrijfJSONObject",
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
          
           $(".annuleren").click(function(){
            $("#panel").hide();
          });

          $(".opslaan").click(function(){
            /**
              *Bij het klikken op opslaan wordt het kamertype object opgeslagen
              */
            schrijfKamertype();
        })
        }

    $(document).ready(function(){
        $("#panel").hide();

        $("#kamertype").change(function() {
            /**
            *Bij het veranderen van de geselecteerde kamertype, veranderdt de info in het panel
            */
            haalKamertype($(this).val());
        });

        $(".delete").click(function (e) {
            /**
            *Bij het klikken op verwijder wordt het kamertype object verwijderdt
            */
            e.preventDefault();
            var id = $("#kamertypeid").html();
            verwijderKamertype(id);
        });

        $("#nieuw").click(function (e){
             /**
            *Bij het klikken op nieuw wordt een nieuw kamertype object opgehaald
            */
            haalKamertype(-1);
        });
    });
</script>


<?php 
$options = array();
foreach($types as $type){
	$options[$type->id] ="$type->omschrijving";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('kamertype', $options, '0', 'id="kamertype" size="10" class="form-control"');?>
        </p>
        </div>
        <p  id="nieuw" class="btn btn-primary">Nieuw</p>
        </br></br>
    </div>

  <div class="col-lg-8">
    <div class="panel panel-default" id="panel">
        <!--<div class="panel-heading">Details</div>-->
        <div class="panel-body">
         
            <div id="resultaat">
                
            </div>
      
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
                      Weet je zeker dat je dit kamertype wil verwijderen?
                  </p>
                  <p hidden id="kamertypeid">
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
                      Je kan dit kamertype niet verwijderen omdat er nog kamers aan verbonden zijn.
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
