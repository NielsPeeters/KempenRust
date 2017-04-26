<script>
    /**
     * \file
     */
    function haalPrijs(arrangementId,kamerTypeId) {
        /**
         * haalt het prijs object op dat behoort tot het meegegeven id
         * \param prijsId het id van de geselecteerde prijs
         * de geselecteerde prijs wordt weergeven in een panel
         */
        $.ajax({
            type: "GET",
            url: site_url + "/prijs/haalPrijs",
            data: {arrangementId: arrangementId,kamerTypeId: kamerTypeId},
            success: function (result) {
                $("#panel").show();
                $("#resultaat").html(result);
                // click aan verwijderen hangen
                attach_click();
                // Geef de verwijder knop van het modalvenster het id van de te verwijderen prijs mee
                resultaat = $(result).find("#id").attr("value");
                $("#prijsId").html(resultaat);

            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    function attach_click() {
        $(".annuleren").click(function () {
            /**
             *Bij het klikken op annuleren wordt het panel verborgen
             */
            $("#panel").hide();
        });
    }

    $(document).ready(function () {
        $("#panel").hide();

        $("#opslaan").on('click', function(){



        });

        $('#arrangementen').on( "change", function(){
            if ($(this).val() == 0){
                $('#pension').show();
                haalPrijs($("#pension option:selected").val(),$("#kamerType option:selected").val());
            } else {
                $('#pension').hide();
                haalPrijs($(this).val(),$("#kamerType option:selected").val());
            }
        });

        $('#pensions').on( "change", function(){

                haalPrijs($(this).val(),$("#kamerType option:selected").val());
        });

        $('#kamerTypes').on( "change", function(){
            if($("#arrangementen option:selected").val() == 0){
                haalPrijs($("#pension option:selected").val(),$(this).val());
            } else{
                haalPrijs($("#arrangementen option:selected").val(),$(this).val());
            }
        });
    });
</script>


<?php
$options0 = array();
$options1 = array();
$options2 = array();

$options0[0] = "Geen arranement";
foreach ($arrangementen as $arrangement) {
    if ($arrangement->isArrangement == 1) {
        $options0[$arrangement->id] = "$arrangement->naam";
    }   else{
        $options1[$arrangement->id] = "$arrangement->naam";
    }
}

$options2 = array();
foreach ($kamerTypes as $kamerType){
    $options2[$kamerType->id] = "$kamerType->omschrijving";
}
?>


<div class="row">
    <div class="col-lg-4">
        <div id="arrangement">
            <p>
                <?php echo form_dropdown('arrangement', $options0, '0', 'id="arrangementen" size="' . count($options0) . '" class="form-control"'); ?>
            </p>
        </div>

        <div id="pension">
            <p>
                <?php echo form_dropdown('pension', $options1, '0', 'id="pensions" size="' . count($options1) . '" class="form-control"'); ?>
            </p>
        </div>

        <div id="kamerType">
            <p>
                <?php echo form_dropdown('kamerTypes', $options2, '0', 'id="kamerTypes" size="' . count($options2) . '" class="form-control"'); ?>
            </p>
        </div>
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
                    Je kan deze prijs niet verwijderen omdat er nog boekingen aan verbonden zijn.
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
