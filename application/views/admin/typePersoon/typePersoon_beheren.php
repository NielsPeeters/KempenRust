<script>
    /**
     * \file
     */
    function haalTypePersoon(typePersoonId)
    {
        /**
         * \file
         * haalt het typePersoon object op dat behoort tot het meegegeven id
         * \param typePersoonId het id van het geselecteerde typePersoon
         * \return de geselecteerde typePersoon in een panel
         */
        $.ajax({type: "GET",
            url: site_url + "/TypePersoon/haalTypePersoon",
            data: {typePersoon: typePersoonId},
            success: function (result) {
                $("#panel").show();
                $("#resultaat").html(result);
                /// click aan opslaan en verwijderen hangen als die er zijn
                attach_click();
                /// Geef de verwijder knop van het modalvenster het id van de te verwijderen typePersoon mee
                resultaat = $(result).find("#id").attr("value");
                $("#typePersoonId").html(resultaat);

            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function verwijderTypePersoon(id)
    {
        /**
         * Verwijdert het typePersoon die behoort tot het meegegeven id
         * \param id het id van de te verwijderen typePersoon als int
         * \return een leeg typePersoon object als het typePersoon verwijderd kon worden, anders geef een foutmelding
         */
        $.ajax({type: "GET",
            url: site_url + "/TypePersoon/verwijderTypePersoon",
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


    function attach_click() {
        $(".verwijder").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het verwijder modal getoond
             */
            e.preventDefault();

            $('#verwijderModal').modal('show');
        });

        $(".annuleren").click(function () {
            $("#panel").hide();
        });
    }

    $(document).ready(function () {
        $("#panel").hide();

        $("#typePersoon").change(function () {
            /**
             *Bij het veranderen van de geselecteerde kamertype, verandert de info in het panel
             */
            haalTypePersoon($(this).val());
        });

        $(".delete").click(function (e) {
            /**
             *Bij het klikken op verwijder wordt het kamertype object verwijderd
             */
            e.preventDefault();
            var id = $("#typePersoonId").html();
            verwijderTypePersoon(id);
        });

        $("#nieuw").click(function (e) {
            /**
             *Bij het klikken op nieuw wordt een nieuw kamertype object opgehaald
             */
            haalTypePersoon(-1);
        });
    });
</script>


<?php
$options = array();
foreach ($typePersonen as $typePersoon) {
    $options[$typePersoon->id] = $typePersoon->soort . "  |  " . toKomma($typePersoon->korting);
}
?>


<div class="row">
    <div  class="col-lg-4" >
        <div id="reload">
            <p>
                <?php echo form_dropdown('typePersoon', $options, '0', 'id="typePersoon" size="10" class="form-control"'); ?>
            </p>
        </div>
        <p  id="nieuw" class="btn btn-primary">Nieuw</p>
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
                    Weet je zeker dat je deze persoonstype wil verwijderen?
                </p>
                <p hidden id="typePersoonId"></p>

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
                    Je kan deze persoonstype niet verwijderen omdat er nog boekingen aan verbonden zijn.
                </p>

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn">Oke</button>
            </div>
        </div>
    </div>
</div>

<p>
    <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>
