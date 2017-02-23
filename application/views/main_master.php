<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CodeIgniter & Bootstrap</title>

    <!-- Bootstrap Core CSS -->
    <?php echo stylesheet("bootstrap.css"); ?>
    <!-- Custom CSS -->
    <?php echo stylesheet("heroic-features.css"); ?>
    <!-- Buttons CSS -->
    <?php echo stylesheet("buttons.css"); ?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php echo javascript("jquery-3.1.0.min.js"); ?>
    <?php echo javascript("bootstrap.js"); ?>

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar">iets</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Hotel Kempenrust</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <?php echo anchor('/home/index', 'Home', 'class="btn btn-default"'); ?>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
    <!-- Page Content -->
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <?php echo $header; ?>
        </header>

        <hr>
        
        <div class="row">
            <div class="col-lg-12">
                <h3><?php echo $title; ?></h3>
            </div>
        </div>
        
        <!-- Page Features -->
        <?php if (isset($nobox)) { ?>
            <div class="row text-center">
                <?php echo $content; ?>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-12 hero-feature">
                    <div class="thumbnail" style="padding: 20px">
                        <div class="caption">
                            <p>
                                <?php echo $content; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>        
        <?php } ?>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <?php echo $footer; ?>
        </footer>
    </div>
    <!-- /.container -->

</body>

</html>
