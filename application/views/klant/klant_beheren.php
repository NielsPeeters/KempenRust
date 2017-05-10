<script>

    function attach_click() {
        $(".opslaan").click(function () {
            /**
             *Bij het klikken op opslaan wordt het kamertype object opgeslagen
             */
            schrijfPersoon();
        })
    }

    $(document).ready(function () {
        $("#panel").hide();

        $("#persoon").change(function () {
            /**
             *Bij het veranderen van de geselecteerde kamertype, verandert de info in het panel
             */
            haalPersoon($(this).val());
        });
    });
</script>

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
                    Je kan dit account niet verwijderen omdat er nog boekingen aan verbonden zijn.
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
