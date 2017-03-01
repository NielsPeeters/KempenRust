<div class="table-responsive">
<table class="table">
    <thead>
        <tr>                                
            <th>Naam</th>
            <th>Beheer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($types as $type) { ?>
            <tr>
                <td><?php echo $type->omschrijving ?></td>
                <td>
                    <button data-toggle="tooltip" data-placement="bottom" title="Wijzigen" class="wijzigKamertype glyphicon glyphicon-pencil btn btn-primary" data-id="<?php echo $type->id ?>"></button>
                    <button data-toggle="tooltip" data-placement="bottom" title="Verwijderen" class="verwijderKamertype glyphicon glyphicon-trash btn btn-danger" data-id="<?php echo $type->id ?>"></button>                                 
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>