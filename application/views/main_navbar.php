<!-- Navigation -->
<!-- Responsive/colapsable navigatie balk -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php // iedereen
            echo  anchor('/home/index', image("logo.PNG",'class="navbar-brand-img"'),'class="navbar-brand"');
            ?>


        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

            <!-- Linkse navbar -->
            <ul class="nav navbar-nav">
                <?php // iedereen
                if ($user == null) { // niet aangemeld
                } else { // wel aangemeld
                    switch ($user->soort) {
                        case 1: // gewone geregistreerde gebruiker
                            echo '<li>' . anchor('/klant/index', 'Boeking maken') . '</li>';
                            echo '<li>' . anchor('/klant/beheren', 'Boekingen beheren') . '</li>';
                            break;
                        case 2: // werknemer
                            echo '<li>' . anchor('/boeking/index', 'Boekingen beheren') . '</li>';
                            break;
                        case 3: // eigenaar ?>
                            <!-- Kamers Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Kamers<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    echo '<li>' . anchor('/kamer/index', 'Kamers beheren') . '</li>';
                                    echo '<li>' . anchor('/kamertype/index', 'Kamer opties beheren') . '</li>';
                                    ?>
                                </ul>
                            </li>
                            <!-- Boekingen Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Boekingen<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                   //echo '<li>' . anchor('/boeking/dashboard', 'Boekingen dashboard') . '</li>';
                                    echo '<li>' . anchor('/boeking/index', 'Boekingen beheren') . '</li>';
                                    ?>
                                </ul>
                            </li>
                            <!-- Arrangementen Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Boeking opties<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    echo '<li>' . anchor('/arrangement/index', 'Arrangementen beheren') . '</li>';
                                    echo '<li>' . anchor('/pension/index', 'Pensions beheren') . '</li>';
                                    echo '<li>' . anchor('/menu/index', 'Menu\'s beheren') . '</li>';
                                    echo '<li>' . anchor('/faciliteit/index', 'Faciliteiten beheren') . '</li>';
                                    ?>
                                </ul>
                            </li>
                            <!-- Extra Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Extra beheren<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    echo '<li>' . anchor('/prijs/index', 'Prijzen beheren') . '</li>';
                                    echo '<li>' . anchor('/typePersoon/index', 'Kortingen beheren') . '</li>';
                                    echo '<li>' . anchor('/persoon/index', 'Accounts beheren') . '</li>';
                                    ?>
                                </ul>
                            </li>
                            <?php

                            break;
                    }
                }

                ?>
            </ul>

            <!-- Rechtse navbar -->
            <ul class="nav navbar-nav navbar-right">
                <?php // iedereen
                if ($user == null) { // niet aangemeld
                    echo '<li>' . anchor('/persoon/nieuw', 'Registreren') . '</li>';
                    echo '<li>' . anchor('#', 'Aanmelden','data-toggle="modal" data-target="#aanmeldModal"') . '</li>';
                    echo '<li>' . anchor('#', '<i class="fa fa-question" aria-hidden="true"></i> Help','data-toggle="modal" data-target="#FAQModal"') . '</li>';
                } else {  ?> <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user" aria-hidden="true"></i> Jouw profiel<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        echo '<li>' . anchor('/klant/haalKlant', 'Accountgegevens') . '</li>';
                        echo '<li>' . anchor('home/afmelden', 'Afmelden') . '</li>';
                        ?>
                    </ul>
                </li>
                    <?php echo '<li>' . anchor('#','<i class="fa fa-question" aria-hidden="true"></i> Help','data-toggle="modal" data-target="#FAQModal"') . '</li>';}?>
            </ul>
        </div>
    </div>
</nav>

<?php //niet aangemeld, zo worden er niet onnuttige gegevens doorgestuurd bij elke pagina. (snellere laadtijden)
if($user == null){
    ?>
    <!-- Modal -->
    <!-- Bevat een aanmeld venster, die via ajax code word gecontroleerd voor de form word ingestuurd. -->
    <div class="modal fade" id="aanmeldModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h3 class="modal-title"> Aanmelden Hotelkempenrust</h3>

                </div>
                <?php // Open Form
                $attributes = array('name' => 'navForm', 'id' => 'navForm');
                echo form_open('Home/aanmelden', $attributes);
                ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required')); ?>
                        </div>

                        <label for="wachtwoord" class="control-label">Wachtwoord</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            <?php echo form_input(array('type' => 'password', 'name' => 'wachtwoord', 'id' => 'wachtwoord', 'class' => 'form-control', 'placeholder' => 'Wachtwoord')); ?>
                        </div>

                        <div id='error' class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" onclick='$("#error").hide();' aria-label="close">&times;</a>
                            Aanmelden mislukt, controleer uw aanmeldgegevens.
                        </div>

                        <hr/>
                        <?php
                        echo anchor('persoon/nieuw', 'Nieuwe gebruiker') . '<br/>';
                        //echo anchor('#', 'Wachtwoord vergeten');
                        ?>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                    <button type="button" id="btn-aanmelden" class="btn btn-primary">Aanmelden</button>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>

    <!-- script verbergt document bij het laden van de pagina,
    Daarna controleert hij of de juiste login gegevens zijn meegegeven.
    als deze kloppen zal de form submitten zo niet word de error getoont. -->
    <script>
        $( document ).ready(function() {
            $('#error').hide();

            $("#btn-aanmelden").click(function(){
                checkAccount();
            });

            $("#wachtwoord, #email").keypress(function(event) {
                if (event.which == 13) {
                    event.preventDefault();
                    checkAccount();
                }
            });

            function checkAccount() {
                var post_url = site_url + '/home/getAjaxLogin';

                $.ajax({
                    type: 'POST',
                    url: post_url,
                    data: $('#navForm').serialize(),
                    success: function (result) {
                        if (result == false) {
                            $('#error').show();
                        }else{
                            $('#navForm').submit();
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("-- Error in ajax main_navbar --\n\n" + xhr.responseText);
                    }
                });
            }
        });
    </script>
<?php } ?>

<!-- Modal -->
<!-- Bevat een venster met frequent gestelde vragen over de applicatie -->
<div class="modal fade" id="FAQModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="modal-title">Frequent gestelde vragen</h3>
        </div>

        <div class="container col-lg-12">
            <div class="row col-lg-12">
                <dl>
                    <?php // iedereen
                    if ($user == null) { // niet aangemeld
                        echo '<dt>Hoe kan ik inloggen?</dt>';
                        echo '<dd>Ben je al geregistreerd?
                                  <ol>
                                    <li>Ja, je kan je aanmelden door je email addres in te geven in het aanmeld venster. Om deze to openen druk je op de aanmeld knop in de navigatiebalk of druk je op een van de voorgaande links.</li>
                                    <li>Nee, zorg dat je eerst registreerd via de ' . anchor('/persoon/nieuw', 'registreer pagina') . '.</li>
                                  </ol></dd>';
                        echo '<dt>Wat moet ik doen wanneer ik mijn passwoord vergeten ben.</dt>';
                        echo '<dd>Neem contact op met ons, wij zullen je voorzien van een tijdelijk wachtwoord waarmee je kan aanmelden.</dd>';
                    } else { // wel aangemeld
                        switch ($user->soort) {
                            case 1: // gewone geregistreerde gebruiker
                                echo '<dt>Hoe kan ik een boeking maken?</dt>';
                                echo '<dd>Klik op de knop ' . anchor('/klant/index', 'Boeking maken') . ' in de navigatiebalk.Je kan ook gerust onze ' . anchor('/klant/help', 'video') . '  die stap per stap uitlegt hoe je kan boeken. ' . anchor('/klant/help', 'Klik hier voor de video te bekijken.') . '</dd>';
                                echo '<dt>Hoe kan ik mijn eigen accountgegevens wijzigen?</dt>';
                                echo '<dd>Klik op de knop Jouw profiel in de navigatiebalk en kies de optie ' . anchor('/klant/haalKlant', 'Accountgegevens') . ' waarna je jou informatie kan aanpassen.</dd>';
                                break;
                            case 2: // werknemer
                                echo '<dt>Hoe kan ik een boeking voor een klant maken?</dt>';
                                echo '<dd>Klik op de knop ' . anchor('/boeking/index', 'Boekingen beheren') . ' in de navigatiebalk. Daarna druk je op de groene knop met als tekst \'Nieuw\' waarna je een gebruiker kan kiezen voor wie je boekt.</dd>';
                                echo '<dt>Hoe kan ik boekingen van klanten beheren?</dt>';
                                echo '<dd>Klik op de knop ' . anchor('/boeking/index', 'Boekingen beheren') . ' waarna alle boekingen worden getoond. Hier kan je boekingen bevestigen, aanpassen of verwijderen</dd>';
                                echo '<dt>Hoe kan ik mijn eigen accountgegevens wijzigen?</dt>';
                                echo '<dd>Klik op de knop Jouw profiel in de navigatiebalk en kies de optie ' . anchor('/klant/haalKlant', 'Accountgegevens') . ' waarna je jou informatie kan aanpassen.</dd>';
                                break;
                            case 3: // eigenaar ?>
                                <dt>Hoe kan ik een mijn kamers aanpassen?</dt>
                                <dd>Klik op Kamers in de navigatiebalk waarna je de optie <?php echo anchor('/kamer/index', 'Kamers beheren')?> neemt. Daar kan je nieuwe kamers toevoegen, kamers aanpassen of verwijderen. </dd>

                                <dt>Hoe kan ik een de kamer opties aanpassen?</dt>
                                <dd>Klik op Kamers in de navigatiebalk waarna je de optie <?php echo anchor('/kamerTypes/index', 'Kamers opties beheren')?> neemt. Daar kan je nieuwe kamers opties toevoegen, kamer opties aanpassen of verwijderen. </dd>

                                <dt>Hoe kan ik een boeking voor een klant maken?</dt>
                                <dd>Klik op de knop Boekingen en neem de optie <?php echo anchor('/boeking/index', 'Boekingen beheren') ?> in de navigatiebalk. Daarna druk je op de groene knop met als tekst Nieuw waarna je een gebruiker kan kiezen voor wie je boekt.</dd>

                                <dt>Hoe kan ik boekingen van klanten beheren?</dt>
                                <dd>Klik op de knop Boekingen en neem de optie <?php echo anchor('/boeking/index', 'Boekingen beheren') ?>  waarna alle boekingen worden getoond. Hier kan je boekingen bevestigen, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik arrangementen aanpassen?</dt>
                                <dd>Klik op de knop Boeking opties en neem de optie <?php echo anchor('/arrangement/index', 'Arrangementen beheren') ?>  waarna alle arrangementen worden getoond. Hier kan je arrangementen aanmaken, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik pensions aanpassen?</dt>
                                <dd>Klik op de knop Boeking opties en neem de optie <?php echo anchor('/pension/index', 'Pensions beheren') ?>  waarna alle penions worden getoond. Hier kan je penions aanmaken, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik menu's aanpassen?</dt>
                                <dd>Klik op de knop Boeking opties en neem de optie <?php echo anchor('/menu/index', 'Menu\'s beheren') ?>  waarna alle menu's worden getoond. Hier kan je menu's aanmaken, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik faciliteiten aanpassen?</dt>
                                <dd>Klik op de knop Boeking opties en neem de optie <?php echo anchor('/faciliteit/index', 'Faciliteiten beheren') ?>  waarna alle faciliteiten worden getoond. Hier kan je faciliteiten aanmaken, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik verschillende soorten prijzen aanpassen?</dt>
                                <dd>Klik op de knop Extra beheren en neem de optie <?php echo anchor('/prijs/index', 'Faciliteiten beheren') ?>  2 - 3 tabellen worden getoond, selecteer voor welke situatie je de prijzen wilt aanpassen en druk op de groene knop opslaan om ze aan te passen.</dd>

                                <dt>Hoe kan ik de kortingen op leeftijds categorie aanpassen?</dt>
                                <dd>Klik op de knop Extra beheren en neem de optie <?php echo anchor('/typePersoon/index', 'Kortingen beheren') ?>  waarna alle kortingen worden getoond. Hier kan je kortingen aanmaken, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik de gebruikers accounts beheren?</dt>
                                <dd>Klik op de knop Extra beheren en neem de optie <?php echo anchor('/persoon/index', 'Kortingen beheren') ?>  waarna alle gebruikers worden getoond. Hier kan je gebruikers aanmaken, aanpassen of verwijderen</dd>

                                <dt>Hoe kan ik mijn eigen accountgegevens wijzigen?</dt>
                                <dd>Klik op de knop Jouw profiel in de navigatiebalk en kies de optie ' . anchor('/klant/haalKlant', 'Accountgegevens') . ' waarna je jou informatie kan aanpassen. Of dit kan je ook doen via de gebruikers accounts beheren.</dd>
                                <?php
                                break;
                        }
                    }

                    ?>
                </dl>
            </div>
        </div>



        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
        </div>
    </div>
</div>
</div>