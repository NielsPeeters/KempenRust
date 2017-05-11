<script>
    /**
     * \file
     */
    function haalArrangement(arrangementId)
    {
        /**
         * haalt het arrangement object op dat behoort tot het meegegeven id
         * \param arrangementId het id van het geselecteerde arrangement
         * het geselecteerde arrangement wordt weergeven in een panel
         */
        $.ajax({type: "GET",
            url: site_url + "/arrangement/haalArrangement",
            data: {arrangementId: arrangementId},
            success: function (result) {
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan verwijderen hangen
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen arrangement mee
                resultaat = $(result).find("#id").attr("value");
                $("#arrangementId").html(resultaat);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function verwijderArrangement(id)
    {
        /**
         * Verwijdert het arrangement die behoort tot het meegegeven id
         * \param id het id van het te verwijderen arrangement als int
         *een leeg arrangement object genereren als het arrangement verwijderd kan worden, anders geef een foutmelding
         */
        $.ajax({type: "GET",
            url: site_url + "/arrangement/verwijderArrangement",
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

        $("#arrangement").change(function () {
            /**
             *Bij het veranderen van het geselecteerde arrangement, verandert de info in het panel
             */
            haalArrangement($(this).val());
        });

        $(".delete").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het arrangement object verwijderd
             */
            e.preventDefault();
            var id = $("#arrangementId").html();
            verwijderArrangement(id);
        });

        $("#nieuw").click(function () {
            /**
             *Bij het klikken op nieuw wordt een nieuw arrangement object opgehaald
             */
            haalArrangement(-1);
        });
    });
</script>


<?php
$options = array();
foreach ($arrangementen as $arrangement) {
    $options[$arrangement->id] = "$arrangement->naam";
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
            <p>
                <?php echo form_dropdown('arrangement', $options, '0', 'id="arrangement" size="10" class="form-control"'); ?>
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
                    Weet je zeker dat je dit arrangement wil verwijderen?
                </p>
                <p hidden id="arrangementId">
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
                    Je kan dit arrangement niet verwijderen omdat er nog boekingen aan verbonden zijn.
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
