<script>
/**
* \file
*/
        function haalMenu(menuId) 
        {
            /**
            * haalt het menu object op dat behoort tot het meegegeven id
            * \param menuId het id van de geselecteerde menu
            * de geselecteerde menu wordt weergeven in een panel
            */
          $.ajax({type : "GET",
            url : site_url + "/menu/haalMenu",
            data : { menuId : menuId },
            success : function(result){
                $("#panel").show();
                $("#resultaat").html(result);
                /// click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                /// Geef de verwijder knop van het modalvenster het id van de te verwijderen menu mee
                resultaat = $(result).find("#id").attr("value");
                $("#menuId").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function verwijderMenu(id) 
        {
            /**
            * Verwijdert de menu die behoort tot het meegegeven id
            * \param id het id van de te verwijderen menu als int
            * een leeg menu object genereren
            */
            $.ajax({type: "GET",
                url: site_url + "/menu/verwijderMenu",
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
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }

        function attach_click() {
          $(".verwijder").click(function (e) {
              /**
              *Bij het klikken op verwijder wordt het verwijder modal getoond
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

        $("#menu").change(function() {
            /**
            *Bij het veranderen van de geselecteerde menu, verandert de info in het panel
            */
            haalMenu($(this).val());
        });

        $(".delete").click(function (e) {
            /**
            *Bij het klikken op verwijder wordt het menu object verwijderd
            */
            e.preventDefault();
            var id = $("#id").val();
            verwijderMenu(id);
        });

        $("#nieuw").click(function (){
            /**
            *Bij het klikken op nieuw wordt een nieuw menu object opgehaald
            */
            haalMenu(-1);
        });
    });
</script>


<?php 
$options = array();
foreach($menus as $menu){
	$options[$menu->id] ="$menu->naam";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
        <p>
            <?php echo form_dropdown('menu', $options, '0', 'id="menu" size="10" class="form-control"');?>
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
                      Weet je zeker dat je deze menu wil verwijderen?
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
                      Je kunt deze menu niet verwijderen omdat er nog arrangementen en/of boekingen aanhangen!
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

