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
                        case 2: // gewone geregistreerde gebruiker
                            echo '<li>' . anchor('#', 'medewerker') . '</li>';
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
                    echo '<li>' . anchor('/persoon/nieuw', 'Registreer') . '</li>';
                    echo '<li>' . anchor('/home/aanmelden', 'Aanmelden') . '</li>';
                } else { // wel aangemeld
                    echo '<li>' . anchor ('home/afmelden', 'Afmelden') . '</li>';
                }

                ?>
            </ul>
        </div>
    </div>
</nav>