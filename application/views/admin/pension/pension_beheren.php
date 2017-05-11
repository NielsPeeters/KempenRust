<script>
    /**
     * \file
     */
    function haalPension(pensionId)
    {
        /**
         * haalt het pension object op dat behoort tot het meegegeven id
         * \param pensionId het id van het geselecteerde pension
         * het geselecteerde pension wordt weergeven in een panel
         */
        $.ajax({type: "GET",
            url: site_url + "/pension/haalPension",
            data: {pensionId: pensionId},
            success: function (result) {
                $("#panel").show();
                $("#resultaat").html(result);
                /// click aan verwijderen hangen
                attach_click();
                /// Geef de verwijder knop van het modalvenster het id van de te verwijderen pension mee
                resultaat = $(result).find("#id").attr("value");
                $("#pensionId").html(resultaat);

            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function verwijderPension(id)
    {
        /**
         * Verwijdert het pension die behoort tot het meegegeven id
         * \param id het id van het te verwijderen pension als int
         *een leeg pension object genereren als het pension verwijderd kan worden, anders geef een foutmelding
         */
        $.ajax({type: "GET",
            url: site_url + "/pension/verwijderPension",
            data: {id: id},
            dataType: "json",
            success: function (result) {
                if (result == 0) {
                    location.reload();
                } else {
                    $("#verwijderFout").modal('show');
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

        $(".annuleren").click(function () {
            /**
             *Bij het klikken op annuleren wordt het panel verborgen
             */
            $("#panel").hide();
        });
    }

    $(document).ready(function () {
        $("#panel").hide();

        $("#pension").change(function () {
            /**
             *Bij het veranderen van het geselecteerde pension, verandert de info in het panel
             */
            haalPension($(this).val());
        });

        $(".delete").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het pension object verwijderd
             */
            e.preventDefault();
            var id = $("#pensionId").html();
            verwijderPension(id);
        });

        $("#nieuw").click(function () {
            /**
             *Bij het klikken op nieuw wordt een nieuw pension object opgehaald
             */
            haalPension(-1);
        });
    });
</script>


<?php
$options = array();
foreach ($pensions as $pension) {
    $options[$pension->id] = "$pension->naam $pension->omschrijving";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
            <p>
                <?php echo form_dropdown('pension', $options, '0', 'id="pension" size="10" class="form-control"'); ?>
            </p>
        </div>
        <p  id="nieuw" class="btn btn-primary">Nieuw</p>
        </br></br>
    </div>

    <div class="col-lg-8">
        <div class="panel panel-default" id="panel">
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
                    Weet je zeker dat je dit pension wil verwijderen?
                </p>
                <p hidden id="pensionId">
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
                    Je kan dit pension niet verwijderen omdat er nog boekingen aan verbonden zijn.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">Oke</button>
            </div>

        </div>
    </div>

</div>

<?php echo "</tbody></table>"; ?>

<p>
    <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>
