<script type="text/javascript">
    /** Gegevens opvragen en tonen */
    function haaloverzicht() {
        $.ajax({type: "GET",
            url: site_url + "/faciliteit/overzicht",
            success: function (result) {
                $("#resultaat").html(result);
                maakDetailClick();
                maakDeleteClick();
                $('.table').DataTable({
                    "aaSorting": []
                });
            }
        });
    }

    /** Wijzigen refreshen */
    function refreshData() {
        haaloverzicht();
    }

    /** Klikken op de Verwijderen knop */
    function maakDeleteClick() {
        $(".verwijderFaciliteit").click(function () {
            deleteid = $(this).data("id");
            $("#faciliteitDelete").modal('show');
        });
    }

    /** Klikken op de Wijzig knop/Toevoeg knop */
    function maakDetailClick() {
        $(".wijzigFaciliteit").click(function () {
            var iddb = $(this).data("id");
            $("#id").val(iddb);
            if (iddb !== 0) {
                /** gegevens ophalen via ajax (doorgeven van server met json) */
                $.ajax({type: "GET",
                    url: site_url + "/faciliteit/detail",
                    async: false,
                    data: {id: iddb},
                    success: function (result) {
                        var jobject = jQuery.parseJSON(result);
                        $("#naam").val(jobject.naam);                        
                    }
                });
            } else {
                /** bij toevoegen gewoon vakken leeg maken */                
                $("#omschrijving").val("");                
            }
            /** dialoogvenster openen */
            $("#faciliteitModal").modal('show');
        });
    }

    $(document).ready(function () {
        /** Link leggen met de knoppen die gemaakt worden in lijst.php */
        maakDetailClick();
        maakDeleteClick();
        /** Lijst eerste maal ophalen en tonen */
        haaloverzicht();

        /** Klikken op "OPSLAAN" in de Detail modal */
        $(".opslaanFaciliteit").click(function () {
            var dataString = $("#JqAjaxForm:eq(0)").serialize();
            $.ajax({
                type: "POST",
                url: site_url + "/faciliteit/update",
                async: false,
                data: dataString,
                dataType: "json"
            });
            refreshData();
            $("#faciliteitModal").modal('hide');
        });

        //Klikken op "BEVESTIG" in de Delete modal
        $(".deleteFaciliteit").click(function () {
            $.ajax({
                type: "POST",
                url: site_url + "/faciliteit/delete",
                async: false,
                data: {id: deleteid},
                success: function (result) {
                    if (result === '0') {
                        alert("Er is iets foutgelopen!");
                    } else {
                        refreshData();
                    }
                    $("#faciliteitDelete").modal('hide');
                }
            });
        });

    });
</script>

    <div class="col-md-10">
        
        <h1>Faciliteiten beheren</h1>  
        <button class="wijzigFaciliteit btn btn-primary" data-id="0">Nieuw faciliteit toevoegen</button>
        
        <div id="resultaat"></div>
        
        <?php echo anchor('admin', 'Annuleren','class="btn btn-default"'); ?>     
        <button class="wijzigFaciliteit btn btn-primary" data-id="0">Nieuw faciliteit toevoegen</button>   
        
    </div>

<!-- MODAL VOOR DETAILS -->         
<div class="modal fade" id="faciliteitModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>

            <div class="modal-body">                  

                <form id="JqAjaxForm">                     
                    <?php echo form_input(array('name' => 'id', 'type'=>'hidden', 'id' =>'id'));?>
                    <p><?php echo form_label('Naam:', 'naam'); ?></p>
                    <p><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control')); ?></p>                   
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="opslaanFaciliteit btn btn-primary">Opslaan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
            </div>

        </div>            
    </div>
</div>  


<!-- MODAL VOOR VERWIJDEREN -->  
<div class="modal fade" id="faciliteitDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">OPGELET!</h4>
            </div>

            <div class="modal-body">                  
                <p>Bent u zeker dat u deze faciliteit wilt verwijderen?</p>  
                <p class="italic">Dit kan niet ongedaan gemaakt worden!</p>                  
            </div>

            <div class="modal-footer">
                <button type="button" class="deleteFaciliteit btn btn-primary">Bevestig</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuleren</button>
            </div>

        </div>            
    </div>
</div>  

