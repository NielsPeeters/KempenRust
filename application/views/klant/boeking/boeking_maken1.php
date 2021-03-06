<script>
    /**
     * \file
     */
    function haalArrangement(arrangementId) {
        $.ajax({type: "GET",
            url: site_url + "/klant/haalJSONArrangement",
            data: {arrangementId: arrangementId},
            success: function (result) {
                try {
                    var arrangement = jQuery.parseJSON(result);
                    $('#arrangementOmschrijving').html(arrangement.omschrijving);
                } catch (error) {
                    alert("-- ERROR IN JSON --\n" + result);
                }
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        var arrangementId;
        $("#arrangementOmschrijving").html("Nog geen arrangement gekozen");
        $("#geenArrangement").hide();

        $("#arrangement").change(function () {
            /**
             *Bij het veranderen van de geselecteerde arrangement, kijkt het systeem of er een arrangement is geselecteerd of de optie 'Geen arrangement' is geselecteerd
             */
            $("#arrangementOmschrijving").html("");
            arrangementId = $(this).val();

            if (arrangementId == 0) {
                $("#arrangementOmschrijving").html("Geen arrangement");
                $("#geenArrangement").show();
            } else {
                haalArrangement(arrangementId);
                $("#geenArrangement").hide();
            }
        });

        $('#volgende').click(function () {
            /** 
             * begindag
             */
            var msecBegin = Date.parse($("#begindatum").val());
            var begindatum = new Date(msecBegin);
            var dagen = ["zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag"];
            var begindag = dagen[begindatum.getDay()];

            /**
             * einddag
             */
            var msecEind = Date.parse($("#einddatum").val());
            var einddatum = new Date(msecEind);
            var einddag = dagen[einddatum.getDay()];

            /**
             * haal begin- en einddag van het arrangement uit de database
             */
            var vandaag = new Date();
            vandaag = Date.parse(vandaag);

            if (msecBegin > vandaag) {
                if (msecEind > msecBegin) {
                    if (arrangementId > 0) {
<?php foreach ($arrangementen as $arrangement) { ?>
                            if (arrangementId == <?php echo $arrangement->id; ?>) {
                                if (begindag == "<?php echo $arrangement->beginDag; ?>") {
                                    if (einddag == "<?php echo $arrangement->eindDag; ?>") {
                                        $('#myform').submit();
                                    } else {
                                        alert("Einddatum is geen <?php echo $arrangement->eindDag; ?>!");
                                    }
                                } else {
                                    if (einddag == "<?php echo $arrangement->eindDag; ?>") {
                                        alert("Begindatum is geen <?php echo $arrangement->beginDag; ?>!");
                                    } else {
                                        alert("Begindatum is geen <?php echo $arrangement->beginDag; ?> en einddatum is geen <?php echo $arrangement->eindDag; ?>!");
                                    }
                                }
                            }
<?php } ?>
                    } else {
                        $('#myform').submit();
                    }
                } else {
                    alert("Einddatum valt vroeger dan begindatum!");
                }
            } else {
                alert("Begindatum valt vroeger dan vandaag!");
            }
        });

        $(".annuleren").click(function () {
            $.ajax({type: "GET",
                url: site_url + "/klant/annuleerBoeking",
                success: function (result) {

                },
                error: function (xhr, status, error) {
                    alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                }
            });
        });
    });
</script>

<style>
    #annuleren {
        color: black;
    }
</style>

<?php
$optionsArrangementen = array();
$optionsArrangementen[0] = "Geen arrangement";
foreach ($arrangementen as $arrangement) {
    $optionsArrangementen[$arrangement->id] = $arrangement->naam;
}

$optionsPensions = array();
foreach ($pensions as $pension) {
    $optionsPensions[$pension->id] = $pension->naam . " " . $pension->omschrijving;
}
?>

<div class="row">
    <?php
    echo javascript("validator.js");
    $attributes = array('name' => 'myform', 'id' => 'myform', 'data-toggle' => 'validator', 'role' => 'form', 'method' => 'get');
    echo form_open('klant/arrangementGekozen', $attributes);
    ?>

    <h4>Kies een begin- en einddatum:</h4>

    <div class="form-group row"> <!--Start + Einddatum-->
        <div class="col-xs-6">
            <?php echo form_label('Van', 'begindatum', 'class="control-label"'); ?>
            <?php echo form_input(array('type' => 'date', 'name' => 'begindatum', 'id' => 'begindatum', 'required' => 'required', 'data-fv-date-format' => 'DD/MM/YYYY', 'class' => 'form-control')); ?>
        </div>
        <div class="col-xs-6">
            <?php echo form_label('Tot', 'einddatum', 'class="control-label"'); ?>
            <?php echo form_input(array('type' => 'date', 'name' => 'einddatum', 'id' => 'einddatum', 'required' => 'required', 'data-fv-date-format' => 'DD/MM/YYYY', 'class' => 'form-control')); ?>
        </div>
        <div class="help-block with-errors"></div>  
    </div>

    <h4>Kies een arrangement:</h4>

    <div class="form-group">
        <div class="col-lg-12">
            <div class="col-md-4">
                <?php echo form_dropdown('arrangement', $optionsArrangementen, '-1', 'id="arrangement" size="10" class="form-control" required="required"'); ?>
            </div>
            <div class="col-md-8"></div>
        </div>
        <div class="help-block with-errors"></div>  
    </div>

    <p>&nbsp;</p>

    <div class="col-lg-12">
        <div class="alert alert-success col-md-4" id="arrangementOmschrijving"></div>
        <div class="col-md-8"></div>
    </div>

    <p>&nbsp;</p>

    <div id="geenArrangement">
        <h4>Geen arrangement</h4>

        <div class="form-group">
            <div class="col-lg-12">
                <div class="col-md-4">
                    <?php echo form_dropdown('pension', $optionsPensions, '-1', 'id="pension" size="10" class="form-control"'); ?>
                </div>
                <div class="col-md-8"></div>
            </div>
            <div class="help-block with-errors"></div>  
        </div>

        <p>&nbsp;</p>
    </div>

    <button type="button" class="btn btn-secondary annuleren"><?php echo anchor('home/index', 'Annuleren', 'id="annuleren"'); ?></button>
    <button type="button" class="btn btn-primary opslaan" id="volgende">Volgende</button>

    <?php echo form_close(); ?>
</div>

<?php echo "</tbody></table>"; ?>

<p>
    <a id="terug" class="btn btn-secondary" href="javascript:history.go(-1);">Terug</a>
</p>

