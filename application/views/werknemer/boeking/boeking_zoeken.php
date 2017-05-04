
<script>
<<<<<<< HEAD
function schrijfBoeking() 
        {
            /**
            *Schrijft de boeking weg in de database
            */
             var dataString = $("#myform").serialize();
          $.ajax({type : "POST",
            url : site_url + "/boeking/schrijfBoeking",
=======
    var comeFromCalendar = "<?php echo $comeFromCalendar; ?>";
    var fromCalendarId = "<?php echo $fromCalendarId; ?>";

    $(document).ready(function () {
        if (comeFromCalendar.toString() === "yes") {
            haalBoeking(fromCalendarId);
            $('.zoek').hide();
            $('#knop').show();
            $('.nav-tabs').hide();
            $('#algemeen').show();
            $('#kamers').hide();
        }
    })

    function schrijfBoeking()
    {
        /**
         *Schrijft de boeking weg in de database
         */
        var dataString = $("#myform").serialize();
        $.ajax({type: "POST",
            url: site_url + "/boeking/schrijfBoeking",
>>>>>>> 9b9dd1d84146f2dc32eefb0a383730a20ddd6cfc
            data: dataString,
            dataType: "json",
            success : function(result){
                //alert(result);
            }
          });
            $('#algemeen').hide();
            $('#kamers').show();
           getKamers();
           
        }

           function getKamers() 
        {
            /**
            * Haalt alle kamers op die bij de boeking horen en geeft ze weer.
            */
          $.ajax({type : "GET",
            url : site_url + "/boeking/gekozenKamers",
            success : function(result){
                
                $("#overzicht").html(result);
                attach_click();
                getPrijs();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

            function getPrijs() 
        {
            /**
            * Berekend de prijs van de boeking zonder kortingen
            */
          $.ajax({type : "GET",
            url : site_url + "/boeking/berekenPrijs",
            success : function(result){
                $("#prijs").val(result);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

          function checkAantallen() 
        {
            /**
            * Gaat na of het aantal opgegeven personen per kamer in de kamers past.
            */
          $.ajax({type : "GET",
            url : site_url + "/boeking/checkAantallen",
            success : function(result){
               if(result==0){
                  alert("Het aantal opgegeven personen komt niet overeen met het aantal personen per kamer."); 
               }
               else{

                       $('.zoek').show();
                    $('#knop').hide();
                    $('#algemeen').hide();
                    $('#kamers').hide();
                    location.reload();
               }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }


    function voegKamerToe() 
        {
            /**
            * opent een form om een kamer aan de boeking toe te voegen
            */
          $.ajax({type : "GET",
            url : site_url + "/boeking/nieuweKamer",
            success : function(result){
                $("#resultaat").html(result);
                $("#resultaat").show();
                attach_click();
                $('#toevoegen').hide();
                $('#geboekteKamers').hide();
                
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
          });
        }

            function nieuweKamer() 
        {
            /**
            * Voegt de gekozen kamer toe aan de database
            */
           
            var dataString = $("#kamerform").serialize();
     
          $.ajax({type : "POST",
            url : site_url + "/boeking/voegKamerToe",
            data: dataString,
            success : function(result){

                getKamers();
                $('#resultaat').hide();
                $('#toevoegen').show();
                $('#geboekteKamers').show();
                
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
                $("#algemeen").html(result);
                // click aan opslaan en verwijderen hangen als die er zij
                attach_click();               
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
            success: function(result) {
                location.reload();
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
              }
        });
    }

     function verwijderBoeking(id) 
        {
            /**
            * Verwijderd te boeking die behoort tot het meegegeven id
            * \param id het id van de te verwijderen boeking als int
            * een leeg boeking object genereren als de boeking verwijderd kan worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/boeking/verwijderBoeking",
                data: {id:id},
                dataType: "json",
                success: function (result) {
                        location.reload();

                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }

        function verwijderKamer(id) 
        {
            /**
            * Verwijderd te boeking die behoort tot het meegegeven id
            * \param id het id van de te verwijderen boeking als int
            * een leeg boeking object genereren als de boeking verwijderd kan worden, anders geef een foutmelding
            */
            $.ajax({type: "GET",
                url: site_url + "/boeking/verwijderKamer",
                data: {id:id},
                dataType: "json",
                success: function (result) {
                        getKamers();

                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        }


function attach_click(){
    $(".vorige").click(function(){
        $('#algemeen').show();
        $('#kamers').hide();
    })

   $(".annuleer").click(function(){
         $('#resultaat').hide();
                $('#toevoegen').show();
                $('#geboekteKamers').show();
    })
    

     $(".verwijderkamer").click(function(){
         var id = $(this).attr('id');
         verwijderKamer(id);
    })

    $('.kamerToevoegen').click(function(){
        var aantal = $('#aantal').val();
        var string =$('#kamer').find(":selected").text();
        var rij = string.split('max:');
        var string2 = rij[1];
        var rij2 = string2.split(' ');
        var aantal2 = rij2[1];
        if(parseInt(aantal) > parseInt(aantal2)){
            alert("Het aantal opgegeven personen past niet in de geselecteerde kamer!");
           // $(".modal-body").html("Het aantal opgegeven personen past niet in de geselecteerde kamer!");
            //$("#waarschuwingModal").modal('show');
            
        }
        else{
            nieuweKamer();
        }
        
    })



   $(".opslaan").click(function(){// datums validatie
         /** 
            * begindag
            */
            var msecBegin = Date.parse($("#beginDatum").val());
           
            var begindatum = new Date(msecBegin);
            var dagen = ["zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag"];
            var begindag = dagen[begindatum.getDay()];
            
            /**
            * einddag
            */
            var msecEind = Date.parse($("#eindDatum").val());
            var einddatum = new Date(msecEind);
            var einddag = dagen[einddatum.getDay()];
            var arrangementId = $('#dropDown').find(":selected").text();
            var pensionId = $('#dropDown').find(":selected").attr('id');
            if(pensionId==0){
                arrangementId = 0;
            }
            /**
             * haal begin- en einddag van het arrangement uit de database
             */
            var vandaag = new Date();
            vandaag = Date.parse(vandaag);
                
            if (msecBegin > vandaag) {
                if (msecEind > msecBegin) {
                    if(arrangementId > 0){
                        <?php foreach($arrangementen as $arrangement){?>
                            if (arrangementId == <?php echo $arrangement->id;?>){
                                if (begindag == "<?php echo $arrangement->beginDag;?>"){
                                    if (einddag == "<?php echo $arrangement->eindDag;?>"){
                                        schrijfBoeking();
                                        return;
                                    } else {
                                        $(".modal-body").html("Einddatum is geen <?php echo $arrangement->eindDag;?>!");
                                        $("#waarschuwingModal").modal('show');
                                    }
                                } else {
                                    if (einddag == "<?php echo $arrangement->eindDag;?>"){
                                         $(".modal-body").html("Begindatum is geen <?php echo $arrangement->beginDag;?>!");
                                        $("#waarschuwingModal").modal('show');
                                    } else {
                                         $(".modal-body").html("Begindatum is geen <?php echo $arrangement->beginDag;?> en einddatum is geen <?php echo $arrangement->eindDag;?>!");
                                        $("#waarschuwingModal").modal('show');
                                    }
                                }
                            }
                        <?php }?>
                    } else {

                        
                        schrijfBoeking();
                        return;
                    }
                } else {
                    $(".modal-body").html('Einddatum valt vroeger dan begindatum!');
                    $("#waarschuwingModal").modal('show');
                }
            } else {
                  $(".modal-body").html('Begindatum valt vroeger dan vandaag!');
                  $("#waarschuwingModal").modal('show');
            }
    });

    


      $('.annuleren').click(function(){
        $('#knop').hide();
        $('.zoek').show();
        $('#algemeen').hide();
        $('#kamers').hide();
        $('.nav-tabs').show();
    })

}
    $(document).ready(function(){
         $('#knop').hide();
          $('#kamers').hide();

           $("#toevoegen").click(function() {
            /**
            *Bij het klikken op de knop om een kamer toe te voegen, wordt de functie om een kamer toe te voegen uitgevoerd
            */
            voegKamerToe();
        });
        

        $("#naam").keyup(function() {
            if ( $(this).val() == "") {
                $("#algemeen").html("");
            } else {
                haalBestelling($(this).val());   
            }
        });

        $(".wijzig").click(function(){
            haalBoeking($(this).attr('id'));
            $('.zoek').hide();
             $('#knop').show();
             $('.nav-tabs').hide();
             $('#algemeen').show();
             $('#kamers').hide();
        })

         $(".nieuw").click(function(){
            haalBoeking(0);
            $('.zoek').hide();
            $('.nav-tabs').hide();
             $('#knop').show();
             $('#algemeen').show();
             $('#kamers').hide();
        })

         $(".delete").click(function(){
            var id = $("#boekingId").html();
            verwijderBoeking(id);
        })

         $("#knop").click(function(){
            $('.zoek').show();
            $('#knop').hide();
            $('.nav-tabs').show();
            $('#algemeen').hide();
            $('#kamers').hide();
        })

         $(".goedkeuren").click(function(){
            goedkeuren($(this).attr('id'));
        })

        $(".verwijder").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het verwijder modal getoont
             */
            var id = $(this).attr('id');
            $("#boekingId").html(id);
            $('#verwijderModal').modal('show');
        });

        $(".check").click(function(){
            checkAantallen();

         
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

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#nietgoedgekeurd">Niet goedgekeurd</a></li>
  <li><a data-toggle="tab" href="#goedgekeurd">Goedgekeurd</a></li>
</ul>

<div class="tab-content">
  <div id="nietgoedgekeurd" class="tab-pane fade in active">
    <div class="zoek">
    </br>
    <input type="text" id="zoekInput" onkeyup="zoek()" placeholder="Zoek op naam of email">

    <table class="table table-responsive " id="boekingen">
    <tr class="success">
        <th>Naam</th>
        <th>Van / Tot</th>
        <th>Arrangement</th>
        <th>Tijdstip</th>
        <th>Goedgekeurd?</th>
        <th>Wijzig</th>
        <th>Verwijder</th>
    </tr>
    <?php

    foreach($NGBoekingen as $boeking){?>
        <tr>
            <td>
                <p><?php echo $boeking->persoon->naam . " " . $boeking->persoon->voornaam; ?></p>
                <p><?php echo $boeking->persoon->email;?></p>
            </td>
            <td>
                <p><?php echo date('d-m-Y',strtotime($boeking->startDatum)); ?></p>
                <p><?php echo date('d-m-Y',strtotime($boeking->eindDatum)); ?></p>
            </td>
            <td>
                <p><?php echo $boeking->arrangement;?></p>
                <p><?php 
                    $aantal="persoon"; 
                    if($boeking->aantalPersonen>1){
                    $aantal="personen";} 
                    echo "$boeking->aantalPersonen $aantal" ; ?>
                </p>
            </td>
            <td><?php echo date('d-m-Y h:m:s',strtotime($boeking->tijdstip)); ?></td>
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
            <td  class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-warning btn-xs btn-round wijzig"><span class="glyphicon glyphicon-pencil"></span></button></td>
            <td  class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijder"><span class="glyphicon glyphicon-remove"></span></button></td>
        </tr>
    <?php

    }

    
    ?>
    </table>
     <button type="button"  class="btn btn-primary nieuw">Nieuw</button>
    </div>
    
  </div>

  <div id="goedgekeurd" class="tab-pane fade">
    <div class="zoek">
    </br>
    <input type="text" id="zoekInput" onkeyup="zoek()" placeholder="Zoek op naam of email">

    <table class="table table-responsive " id="boekingen">
    <tr class="success">
        <th>Naam</th>
        <th>Van / Tot</th>
        <th>Arrangement</th>
        <th>Tijdstip</th>
        <th>Goedgekeurd?</th>
        <th>Wijzig</th>
        <th>Verwijder</th>
    </tr>
    <?php

    foreach($GBoekingen as $GBoeking){?>
        <tr>
            <td>
                <p><?php echo $GBoeking->persoon->naam . " " . $GBoeking->persoon->voornaam; ?></p>
                <p><?php echo $boeking->persoon->email;?></p>
            </td>
            <td>
                <p><?php echo date('d-m-Y',strtotime($GBoeking->startDatum)); ?></p>
                <p><?php echo date('d-m-Y',strtotime($GBoeking->eindDatum)); ?></p>
            </td>
            <td>
                <p><?php echo $GBoeking->arrangement;?></p>
                <p><?php 
            $aantal="persoon"; 
            if($GBoeking->aantalPersonen>1){
            $aantal="personen";} 
            echo "$GBoeking->aantalPersonen $aantal" ; ?></p>
            </td>
            <td><?php echo date('d-m-Y h:m:s',strtotime($GBoeking->tijdstip)); ?></td>
            <td class="text-center">
            <?php 
            if($GBoeking->goedgekeurd==1){
                echo '<button type="button"' . "id= $GBoeking->id" .' class="btn btn-success btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
            }
            else{
                echo '<button type="button"' . "id= $GBoeking->id" .' class="btn btn-danger btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
            }
            ?>
            </td>
            <td  class="text-center"><button type="button" id="<?php echo $GBoeking->id; ?>" class="btn btn-warning btn-xs btn-round wijzig"><span class="glyphicon glyphicon-pencil"></span></button></td>
            <td  class="text-center"><button type="button" id="<?php echo $GBoeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijder"><span class="glyphicon glyphicon-remove"></span></button></td>
        </tr>
        
    <?php

    }

    
    ?>
    </table>
     <button type="button"  class="btn btn-primary nieuw">Nieuw</button>
    </div>
    
  </div>
</div>



<button id="knop" type="button" class="btn btn-primary btn-block">Geef alle boekingen weer</button>


<div id="algemeen"></div>
<div id="kamers">

 <h4>Kamer(s) kiezen</h4>
    <p>Overzicht gekozen kamer(s):</p>
    <div id="overzicht">
    </div>
    <button class="btn btn-primary" id="toevoegen">Voeg een kamer toe</button>
     
    <div id="resultaat">
    </div>
    </br>
    </br>
    <label for="prijs">Prijs (zonder korting)</label>
    <input class='form-control' id="prijs" disabled></input>
    </br>
     <button type="button" class="btn btn-secondary annuleren">Annuleren</button>
    <button type="button" class="btn btn-secondary vorige">Vorige</button>
    <button type="button" class="btn btn-primary check">Opslaan</button>

</div>


<p>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</p>

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
                  <p hidden id="boekingId"></p>
              </div>
              <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn btn-warning delete" id="id">Verwijderen</button>
                  <button type="button" data-dismiss="modal" class="btn">Annuleren</button>
              </div>
              
          </div>
      </div>

  </div>

  <div class="modal fade" id="waarschuwingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Waarschuwing</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>
