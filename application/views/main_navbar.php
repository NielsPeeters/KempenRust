
<script>

</script>


<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php // iedereen
                echo  anchor('/home/index', 'HotelKempenrust','class="navbar-brand"');
            ?>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

            <!-- Linkse navbar -->
            <ul class="nav navbar-nav">
                <?php // iedereen
                echo '<li>' . anchor('/home/index', 'Index') . '</li>';
                echo '<li>' . anchor('#', 'iedereen') . '</li>';
                if ($user == null) { // niet aangemeld
                } else { // wel aangemeld
                    switch ($user->soort) {
                        case 1: // gewone geregistreerde gebruiker
                            echo '<li>' . anchor('#', 'ingelogde_gebruiker') . '</li>';
                            break;
                        case 2: // werknemer
                            echo '<li>' . anchor('#', 'werknemer') . '</li>';
                            break;
                        case 3: // eigenaar
                            echo '<li>' . anchor('#', 'eigenaar') . '</li>';
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

<!-- Modal -->
<div class="modal fade" id="aanmeldModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Aanmelden Hotelkempenrust</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php // Open Form
            $attributes = array('name' => 'myform');
            echo form_open('Home/aanmelden', $attributes);
            ?>

            <div class="modal-body">
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required')); ?>

                    <label for="wachtwoord" class="control-label">Wachtwoord</label>
                    <?php echo form_input(array('type' => 'password', 'name' => 'wachtwoord', 'id' => 'wachtwoord', 'class' => 'form-control', 'placeholder' => 'Wachtwoord')); ?>

                <hr/>
                    <?php
                        echo anchor('/persoon/nieuw', 'Nieuwe gebruiker');
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                <button type="submit" class="btn btn-primary">Aanmelden</button>
            </div>
            <?php
                echo form_close();
            ?>
        </div>
    </div>
</div>