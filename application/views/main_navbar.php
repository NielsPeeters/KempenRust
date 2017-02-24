
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <ul class="nav navbar-nav">
            <?php // iedereen
                echo '<li>' . anchor('/home/index', 'Index') . '</li>';

                if ($user == null) { // niet aangemeld
                    echo '<li>' . anchor('/home/aanmelden', 'Aanmelden') . '</li>';
                } else { // wel aangemeld
                    echo '<li>' . anchor ('home/afmelden', 'Afmelden') . '</li>';
                    switch ($user->level) {
                        case 1: // gewone geregistreerde gebruiker
                            echo '<li>' . anchor('/home/aanmelden', 'Aanmelden') . '</li>';
                            break;
                        case 5: // administrator
                            echo '<li>' . anchor('/home/aanmelden', 'Aanmelden') . '</li>';
                            break;
                    }
                }

            ?>
        </ul>
    </div>
</nav>