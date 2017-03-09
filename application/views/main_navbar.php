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
                            echo '<li>' . anchor('#', 'ingelogde_gebruiker') . '</li>';
                            break;
                        case 2: // werknemer
                            echo '<li>' . anchor('#', 'werknemer') . '</li>';
                            echo '<li>' . anchor('/boeking/index', 'Boekingen beheren') . '</li>';
                            break;
                        case 3: // eigenaar ?>
                            <!-- Kamers Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Kamers<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    echo '<li>' . anchor('/kamer/index', 'Kamers beheren') . '</li>';
                                    echo '<li>' . anchor('/kamertype/index', 'Kamertypes beheren') . '</li>';
                                    ?>
                                </ul>
                            </li>
                            <!-- Boekingen Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Boekingen<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    echo '<li>' . anchor('/boeking/index', 'Boekingen beheren') . '</li>';
                                    ?>
                                </ul>
                            </li>
                            <!-- Extra Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Extra beheren<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php
                                    echo '<li>' . anchor('/faciliteit/index', 'Faciliteiten beheren') . '</li>';
                                    echo '<li>' . anchor('/menu/index', 'Menu\'s beheren') . '</li>';
                                    echo '<li>' . anchor('/pension/index', 'Pensions beheren') . '</li>';
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
                } else { // wel aangemeld
                    echo '<li>' . anchor ('home/afmelden', 'Afmelden') . '</li>';
                }

                ?>
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
                        <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required')); ?>

                        <label for="wachtwoord" class="control-label">Wachtwoord</label>
                        <?php echo form_input(array('type' => 'password', 'name' => 'wachtwoord', 'id' => 'wachtwoord', 'class' => 'form-control', 'placeholder' => 'Wachtwoord')); ?>


                        <div id='error' class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Aanmelden mislukt, controleer uw aanmeldgegevens.
                        </div>

                        <hr/>
                        <?php
                            echo anchor('/persoon/nieuw', 'Nieuwe gebruiker') . '<br/>';
                            echo anchor('#', 'Wachtwoord vergeten');
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

            $('#btn-aanmelden').click(function (event) {
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
            });
        });
    </script>
<?php } ?>