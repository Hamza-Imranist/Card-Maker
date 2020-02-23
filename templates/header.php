<!DOCTYPE html>

<html>
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
        <title><?php echo empty($config) ? 'Installation' : $config['siteName']?> - Cards maker</title>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <base href="<?php echo sitePath() ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <?php if(!empty($config)) { ?>        
        <meta name="Robots" content="<?php echo empty($_GET['p']) ? 'index,' : ''?>follow" />
        <meta name="application-name" content="Cards Maker" />
        <meta name="msapplication-starturl" content="<?php echo sitePath() ?>" />        
        
        <!--Scoial-->
        <meta property="fb:app_id" content="<?php echo $config['facebookAppID']?>" /> 
        <meta property="og:type" content="website" />         
        <meta property="og:title" content="<?php echo $config['siteName']?> - Cards maker" />
        <meta property="og:description" content="<?php echo $config['siteName']?> - Cards maker" />
        <meta property="twitter:title" content="<?php echo $config['siteName']?> - Cards maker" />
        <meta property="twitter:description" content="<?php echo $config['siteName']?> - Cards maker" />
        <meta property="twitter:site" content="cardsmaker" /> 

        
        <?php if(!empty($config['metaImage'])) { ?>
            <meta property="og:image" content="<?php echo $config['metaImage']?>" />
            <meta property="twitter:image" content="<?php echo $config['metaImage']?>" />
            <meta property="twitter:card" content="summary_large_image" />
            <meta property="twitter:image:alt" content="<?php echo $config['siteName']?> - Cards maker" />
            
        <?php } 
        ?>
            <meta property="og:url" content="<?php echo currentURL() ?>" />
        <?php
         } ?> 
        
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        
        <link href="lib/bootstrap.min.css" rel="stylesheet" type="text/css" />        
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link href="css/photo-editor.css?v=<?php echo $GLOBALS['_v']?>" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/spectrum.css" rel="stylesheet" type="text/css" />
        
        <script src="lib/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="lib/helpers.js" type="text/javascript"></script>
        <script src="lib/jcanvas.min.js" type="text/javascript"></script>
        <script src="lib/bootstrap.min.js" type="text/javascript"></script>
        <script src="lib/photoEditor.js?v=<?php echo $GLOBALS['_v']?>" type="text/javascript"></script>
        <script src="lib/jquery-ui.js" type="text/javascript"></script>
        <script src="lib/spectrum.js" type="text/javascript"></script>        
        
        
        
        <link href="css/google-fonts.css" rel="stylesheet" type="text/css"/>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <style type="text/css">
            #the-loading div
            {
                width: 0%;
                height: 5px;
            }
            #the-loading
            {
                position: fixed !important;
                z-index: 5;
                bottom: 0px;
                left: 0;
                right: 0;
                display: block;
            }
            #loadingForm
            {
                opacity: 0.8;
                background-color: #fff;
                position: fixed;
                z-index: 999999;
                display: none;
                top:0;
                bottom: 0;
                left: 0;
                right: 0;
                width: 100%;
                height: 100%;
                /*cursor: wait;*/            
            }
            #loadingForm div
            {
                background-color: #fff;
                background-position: center 20px;
                background-repeat: no-repeat;
                width: 420px;            
                padding-top: 120px;
                text-align: center;
                margin: auto;
                margin-top: 100px;
                border-radius: 10px;
            }
        </style>
    </head>
    <body>
        <!--Loading bar-->
        <div id="loadingForm">
            <div class="text-center">
                <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>
        </div>
      
        <!--End Loading bar-->
        
        <?php if(!empty($config)) { ?>
        <header class="navbar navbar-static-top navbar-inverse" id="top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.php" id="brand" class="navbar-brand">
                        <?php echo $config['siteName']?>
                        <?php if(demoMode) { ?>
                            <small class="text-warning btn-sm">
                                <i class="fa fa-warning"></i> Demo mode is active
                            </small>
                        <?php } ?>
                    </a>     
                    
                    
                    
                </div>

                <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">    
                    <ul class="nav navbar-nav navbar-right">          
                        <?php if(isAdmin) { ?>
                        <li><a href="?p=new">Upload</a></li>
                        <li><a href="?do=logout">Logout</a></li>
                        <?php } if(!isAdmin) { ?>
                        <li>
                            <a href="#" onclick="login();return false;">Login</a>                            
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="container">
            <div class="col-md-12 text-center visible-lg">
                <?php showAds1()?>
            </div>
            <div class="clearfix"></div>
        <?php } ?>
