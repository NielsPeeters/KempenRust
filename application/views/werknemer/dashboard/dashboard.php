<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    $.getScript('http://arshaw.com/js/fullcalendar-1.6.4/fullcalendar/fullcalendar.min.js', function () {
//Get All Boekingen From PHP
        var boekingenEvent = <?php echo json_encode($boekingen); ?>;
        var baseurl = "<?php echo base_url();?>";
        //CreateArrayWithObjectsForEvents
        var eventArray = new Array();
        for (var i = 0; i < boekingenEvent.length; i++) {

            //Check if kamerBoeking is set
            if (boekingenEvent[i].kamerBoeking["0"] == null) {

            } else {
                var newEvent = {
                    //Only first object of Kamerboeking (only one kamerboeking referenced in object) if more objects 'kamerBoeking' returned, funciton needs to be re-written with foreach
                    title: boekingenEvent[i].kamerBoeking["0"].Kamer.naam,
                    start: boekingenEvent[i]["startDatum"],
                    end: boekingenEvent[i]["eindDatum"],
                    url: baseurl + "index.php/boeking/index/" + boekingenEvent[i].kamerBoeking["0"].Boeking.id
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
            editable: true,
            events: eventArray
        });
    });
</script>

<hr>
<div id="calendar"></div>
</div>