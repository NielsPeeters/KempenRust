<script>
    /**
     * \file
     */
    function haalPersoon(persoonId)
    {
        /**
         * \file
         * haalt het persoon object op dat behoort tot het meegegeven id
         * \param persoonId het id van de geselecteerde persoon
         * \return de geselecteerde persoon in een panel
         */
        $.ajax({type: "POST",
            url: site_url + "/persoon/haalPersoon",
            data: {persoonId: persoonId},
            success: function (result) {
                $("#panel").show();
                $("#resultaat").html(result);
                /// click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                /// Geef de verwijder knop van het modalvenster het id van de te verwijderen klant mee
                resultaat = $(result).find("#id").attr("value");
                $("#persoonid").html(resultaat);

            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function verwijderPersoon(id)
    {
        /**
         * Verwijdert de persoon die behoort tot het meegegeven id
         * \param id het id van de te verwijderen persoon als int
         * \return een leeg klant object als de persoon verwijderd kon worden, anders geef een foutmelding
         */
        $.ajax({type: "GET",
            url: site_url + "/persoon/verwijderPersoon",
            data: {id: id},
            dataType: "json",
            success: function (result) {
                if (result == 0) {
                    location.reload();
                } else {
                    $("#verwijderfout").modal('show');
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

//        function schrijfPersoon()
//        {
//            /**
//            * Update of insert een persoonobject
//            * \param id het id van het te verwijderen persoon als int
//            * \return een melding dat de gegevens succesvol zijn opgeslagen
//            */
//            var dataString = $("#JqAjaxForm").serialize();
//            $.ajax({type: "POST",
//                url: site_url + "/persoon/schrijfJSONObject",
//                data: dataString,
//                dataType: "json",
//                success: function (result) {
//                    location.reload();
//                },
//                error: function (xhr, status, error) {
//                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
//                }
//            });
//        }

    function attach_click() {
        $(".verwijder").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het verwijder modal getoont
             */
            e.preventDefault();
            var id = $(this).data('id');
            $('#verwijderModal').modal('show');
        });

        $(".annuleren").click(function () {
            $("#panel").hide();
        });

        $(".opslaan").click(function () {
            /**
             *Bij het klikken op opslaan wordt het persoon object opgeslagen
             */
            schrijfPersoon();
        })
    }

    $(document).ready(function () {
        $("#panel").hide();

        $("#klant").change(function () {
            /**
             *Bij het veranderen van de geselecteerde persoon, verandert de info in het panel
             */
            haalPersoon($(this).val());
        });

        $(".delete").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het persoon object verwijderd
             */
            e.preventDefault();
            var id = $("#persoonid").html();
            verwijderPersoon(id);
        });

        $("#nieuw").click(function (e) {
            /**
             *Bij het klikken op nieuw wordt een nieuw persoon object opgehaald
             */
            haalPersoon(-1);
        });
    });
</script>


<?php
$options = array();
foreach ($klanten as $klant) {
    $options[$klant->id] = "$klant->naam $klant->voornaam";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
            <p>
                <?php echo form_dropdown('klant', $options, '0', 'id="klant" size="10" class="form-control"'); ?>
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
                    Weet je zeker dat je dit account wil verwijderen?
                </p>
                <p hidden id="persoonid">
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
                    Je kan dit account niet verwijderen.
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
