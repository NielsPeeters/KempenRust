<script>
     if(window.onload) {
    $.getScript('../../assets/js/kalender.js', function () {

        ///GetAllBoekingsFromPHP
        var boekingenEvent = <?php echo json_encode($boekingen); ?>;
        ///CreateArrayWithObjectsForEvents


        var eventArray = new Array();
        for (var i = 0; i < boekingenEvent.length; i++) {


            ///Check if kamerBoeking is set
            if (boekingenEvent[i].kamerBoeking["0"] == null) {

            } else {
                var newEvent = {
                    //Only first object of Kamerboeking (only one kamerboeking referenced in object) if more objects 'kamerBoeking' returned, funciton needs to be re-written with foreach
                    title: boekingenEvent[i].kamerBoeking["0"].Kamer.naam,
                    start: boekingenEvent[i]["startDatum"],
                    end: boekingenEvent[i]["eindDatum"]
                };
                eventArray.push(newEvent);
            }


        }

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: eventArray
        });
    });
    };


</script>
<h1>Arrangementen</h1>
<div class="row">   
    
    <?php foreach ($arrangementen as $arrangement) { ?>  
    
        <h4><?php echo $arrangement->naam ?></h4>
        <p><?php echo $arrangement->omschrijving ?></p>
    <?php } ?>
</div>

<hr>
<h1>Kalender</h1>
<div style="overflow-x:auto;" class="row">  
    <div style="overflow-x:auto;" class="col-sm-12">  
        <div id="calendar"></div>
    </div>
</div>
