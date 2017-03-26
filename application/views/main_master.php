<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel=icon href="<?php echo base_url();?>/assets/images/favicon.ico" type="image/png">
    <meta name="description" content="Dit is een demoproject opgesteld in opracht van Thomas More. Dit is een webapplicatie gemaakt door studenten voor het te volbrengen van hun studiecrediet.">
    <meta name="author" content="<?php echo $author;?>">

    <title><?php echo $title?></title>

    <!-- Bootstrap Core CSS -->
    <?php echo stylesheet("bootstrap.css"); ?>
    <!-- Custom CSS -->
    <?php echo stylesheet("heroic-features.css"); ?>
    <!-- Jquery UI CSS -->
    <?php echo stylesheet("jquery-ui.css"); ?>
    <!-- Buttons CSS -->
    <?php echo stylesheet("buttons.css"); ?>
    <!-- Custom CSS -->
    <?php echo stylesheet("Custom.css"); ?>
    <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php 
    echo javascript("jquery-3.1.0.min.js"); 
    echo javascript("jquery-ui.js"); 
    echo javascript("bootstrap.js"); 
    echo javascript("bootstrap-datepicker.js");
?>
    

    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.nl.js"></script>

    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>

<body>
<?php echo $navbar ?>

<!-- Page Title -->
<header class="jumbotron jumbotron-fluid">
    <div id="header" class="container">
        <div class="row">
            <div class="text-center">
                <h1><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<!-- Page Container -->
<div class="container">

    <!-- Page Content -->
    <?php if (isset($nobox)) { ?>
        <div class="row text-center">
            <?php echo $content; ?>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="thumbnail" style="padding: 20px">
                    <div class="caption">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


<!-- Footer -->
<footer class="footer">
    <?php echo $footer; ?>
</footer>
</body>
</html>
