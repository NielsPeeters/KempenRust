<script>
 function verwijderBoeking(id) 
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

    function haalBoeking (boekingId) 
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
                // click aan opslaan en verwijderen hangen als die er zij
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen boeking mee
                resultaat = $(result).find("#id").attr("value");
                $("#boekingId").html(resultaat);
             
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

        function goedkeuren(id){
            /**
            * veranderd de waarde van goedgekeurd
            */
          $.ajax({type : "GET",
            url : site_url + "/boeking/setGoedkeuring",
            data : { id : id },
            success: function() {
                location.reload();
            }
        });
    }

    $(document).ready(function(){
         $('#knop').hide();

        $("#naam").keyup(function() {
            if ( $(this).val() == "") {
                $("#resultaat").html("");
            } else {
                haalBestelling($(this).val());   
            }
        });

        $(".wijzig").click(function(){
            haalBoeking($(this).attr('id'));
            $('#zoek').hide();
             $('#knop').show();
             $('#resultaat').show();
        })

         $(".verwijder").click(function(){
            verwijderBoeking($(this).attr('id'));
        })

         $("#knop").click(function(){
            $('#zoek').show();
            $('#knop').hide();
            $('#resultaat').hide();
        })

         $(".goedkeuren").click(function(){
            goedkeuren($(this).attr('id'));
        })



    });

function zoek() {
  // Variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("zoekInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("boekingen");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
<style>
#zoekInput {
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}

</style>
<button id="knop" type="button"  class="btn btn-primary">Geef alle boekingen weer</button>
<div id="zoek">
    <input type="text" id="zoekInput" onkeyup="zoek()" placeholder="Zoek op naam">

    <table class="table" id="boekingen">
    <tr class="success">
        <th>Naam</th>
        <th>Van</th>
        <th>Tot</th>
        <th>email</th>
        <th>Goedgekeurd?</th>
        <th>Wijzig</th>
        <th>Verwijder</th>
    </tr>
    <?php

    foreach($boekingen as $boeking){?>
        <tr>
            <td><?php echo $boeking->persoon->naam . " " . $boeking->persoon->voornaam; ?></td>
            <td><?php echo $boeking->startDatum; ?></td>
            <td><?php echo $boeking->eindDatum; ?></td>
            <td><?php echo $boeking->persoon->email; ?></td>
            <td class="text-center">
            <?php 
            if($boeking->goedgekeurd==1){
                echo '<button type="button"' . "id= $boeking->id" .' class="btn btn-success btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
            }
            else{
                echo '<button type="button"' . "id= $boeking->id" .' class="btn btn-danger btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
            }
            ?>
            </td>
            <td class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-warning btn-xs btn-round wijzig"><span class="glyphicon glyphicon-pencil"></span></button></td>
            <td class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijder"><span class="glyphicon glyphicon-remove"></span></button></td>
        </tr>
    <?php
    }

    ?>
    </table>
</div>
<p>
<div id="resultaat"></div>
</p>


<p>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</p>

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
