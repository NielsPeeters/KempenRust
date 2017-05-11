<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#nietgoedgekeurd">Niet goedgekeurd</a></li>
    <li><a data-toggle="tab" href="#goedgekeurd">Goedgekeurd</a></li>
</ul>

<div class="tab-content">
    <div id="nietgoedgekeurd" class="tab-pane fade in active">
        <div class="resultaat"></div>
        <div class="zoek">
            </br>
            <input type="text" id="zoekInput"  placeholder="Zoek op naam">

            <table class="table table-responsive " id="boekingen">
                <tr class="success">
                    <th>Naam</th>
                    <th>Van / Tot</th>
                    <th>Arrangement</th>
                    <th>Tijdstip</th>
                    <th>Goedgekeurd?</th>
                    <th>Wijzig</th>
                    <th>Verwijder</th>
                </tr>
                <?php foreach ($NGBoekingen as $boeking) { ?>
                    <tr>
                        <td>
                            <div>
                                <p><?php echo $boeking->persoon->naam . " " . $boeking->persoon->voornaam; ?></p>
                                <p><?php echo $boeking->persoon->email; ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><?php echo date('d-m-Y', strtotime($boeking->startDatum)); ?>
                                <p><?php echo date('d-m-Y', strtotime($boeking->eindDatum)); ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><?php echo $boeking->arrangement; ?></p>
                                <p><?php
                                    $aantal = "persoon";
                                    if ($boeking->aantalPersonen > 1) {
                                        $aantal = "personen";
                                    }
                                    echo "$boeking->aantalPersonen $aantal";
                                    ?></p>
                            </div>
                        </td>
                        <td><?php echo date('d-m-Y h:m:s', strtotime($boeking->tijdstip)); ?></td>
                        <td class="text-center">
                            <?php
                            if ($boeking->goedgekeurd == 1) {
                                echo '<button type="button"' . "id= $boeking->id" . ' class="btn btn-success btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
                            } else {
                                echo '<button type="button"' . "id= $boeking->id" . ' class="btn btn-danger btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
                            }
                            ?>
                        </td>
                        <td  class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-warning btn-xs btn-round wijzig"><span class="glyphicon glyphicon-pencil"></span></button></td>
                        <td  class="text-center"><button type="button" id="<?php echo $boeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijder"><span class="glyphicon glyphicon-remove"></span></button></td>
                    </tr>

                    <?php
                }
                ?>
            </table>
            <button type="button"  class="btn btn-primary nieuw">Nieuw</button>
        </div>

    </div>

    <div id="goedgekeurd" class="tab-pane fade">
        <div class="zoek">
            </br>
            <input type="text" id="zoekInput" placeholder="Zoek op naam">

            <table class="table table-responsive " id="boekingen">
                <tr class="success">
                    <th>Naam</th>
                    <th>Van / Tot</th>
                    <th>Arrangement</th>
                    <th>Tijdstip</th>
                    <th>Goedgekeurd?</th>
                    <th>Wijzig</th>
                    <th>Verwijder</th>
                </tr>
                <?php foreach ($GBoekingen as $GBoeking) { ?>
                    <tr>
                        <td>
                            <div>
                                <p><?php echo $GBoeking->persoon->naam . " " . $GBoeking->persoon->voornaam; ?></p>
                                <p><?php echo $GBoeking->persoon->email; ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><?php echo date('d-m-Y', strtotime($GBoeking->startDatum)); ?>
                                <p><?php echo date('d-m-Y', strtotime($GBoeking->eindDatum)); ?></p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p><?php echo $GBoeking->arrangement; ?></p>
                                <p><?php
                                    $aantal = "persoon";
                                    if ($GBoeking->aantalPersonen > 1) {
                                        $aantal = "personen";
                                    }
                                    echo "$GBoeking->aantalPersonen $aantal";
                                    ?></p>
                            </div>
                        </td>
                        <td><?php echo date('d-m-Y h:m:s', strtotime($GBoeking->tijdstip)); ?></td>
                        <td class="text-center">
                            <?php
                            if ($GBoeking->goedgekeurd == 1) {
                                echo '<button type="button"' . "id= $GBoeking->id" . ' class="btn btn-success btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
                            } else {
                                echo '<button type="button"' . "id= $GBoeking->id" . ' class="btn btn-danger btn-xs btn-round goedkeuren"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
                            }
                            ?>
                        </td>
                        <td  class="text-center"><button type="button" id="<?php echo $GBoeking->id; ?>" class="btn btn-warning btn-xs btn-round wijzig"><span class="glyphicon glyphicon-pencil"></span></button></td>
                        <td  class="text-center"><button type="button" id="<?php echo $GBoeking->id; ?>" class="btn btn-danger btn-xs btn-round verwijder"><span class="glyphicon glyphicon-remove"></span></button></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <button type="button"  class="btn btn-primary nieuw">Nieuw</button>
        </div>

    </div>
</div>