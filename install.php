<?php
if($_SERVER['HTTP_HOST'] == 'demos.codesgit.com') exit;
include_once 'functions.php';
$options = (object) array();
if(empty($_GET['p'])) $_GET['p'] = 'check';

$options->required = array(
    "PHP 5.3 or higher and less or equal to PHP 5.6" => array(phpversion(), 5.3, array('value' => 7)),        
    "Minuman Upload files size (2M)" => array(file_upload_max_size(), 2097152),        
);
$options->recommended = array();
$options->verify = array();
$verified = true;


foreach(array('required', 'recommended') as $kk)
{
    $options->verify[$kk] = array();
    foreach($options->{$kk} as $k=>$req)
    {
        $status = false;
        if(isset($req[1]))
        {
            if(is_numeric($req[1]))
            {
                $status = (float) $req[0] >= $req[1];
                if(!empty($req[2]['value']) && is_numeric($req[2]['value']) && $status)
                {                    
                    $status = $req[0] < $req[2]['value'];
                    $options->{$kk}[$k][2] = $req[0];
                }
            }
            else $status = $req[0] == $req[1];
        }
        else 
        {
            $status = $req[0];
            $options->{$kk}[$k][1] = true;
        }
        
        if(empty($req[2])) $options->{$kk}[$k][2] = $req[0];
        if(empty($req[3])) $options->{$kk}[$k][3] = $req[0];
        
        if(!$status && $kk == 'required') $verified = false;
        $options->verify[$kk][$k] = $status;
    }
}

if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['website']))
{
    @file_put_contents('config.php', "<?php

return array(
    'siteName' => '".clearParam($_POST['website'])."',  //Your website name
    'username' => '".clearParam($_POST['username'])."', //Your admin username
    'password' => '".clearParam($_POST['password'])."', //Your admin password
    'adsensPublishKey' => '".clearParam($_POST['adsensPublishKey'])."', //Adsens Publish key
    'facebookAppID' => '314235422399273',//facebook Application ID    
    'cardsMailFormat' => '".clearParam($_POST['cardsMailFormat'])."', //send card by mail as (attachment | image | both) **** WARNING: (image or both) may servers detect the mail as spam   
    'senderMail' => 'no-replay@".serverName()."', //The Sender E-mail address
    'dir' => '__bgs__', //Orginal Images directory  
);");
    if($_SERVER['HTTP_HOST'] != 'localhost')
    {
        @rename('install.php', '__'.uniqid().'_install.php');
    }
    header('location: index.php');
    exit;
}
include_once 'templates/header.php';
?>
<header class="navbar navbar-static-top navbar-inverse" id="top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="brand" class="navbar-brand">Installation page</a>      
        </div>

    </div>
</header>
<div class="container">
    <?php
    if(!empty($options->required))
    {
        ?>
            <?php foreach(array('required', 'recommended') as $kk) { ?>
            <?php if($kk == 'required') { ?>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                <b>Required</b> (These items are necessary in order to install and use )
            </div>
            <?php }
            if($kk == 'recommended' && count($options->{$kk}) > 0) { ?>
            <tr>
                <th colspan="2"><b>Recommended</b> </th>
            </tr>
            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i>
                Recommended
            </div>
            
            <ul class="list-group">
            <?php }
            foreach($options->{$kk} as $k=>$req) { ?>
            
            <li class="list-group-item list-group-item-<?php echo $options->verify[$kk][$k] ? 'success' : 'danger';?>">
                <i class="fa fa-<?php echo $options->verify[$kk][$k] ? 'check' : 'remove';?>"></i>
                <b><?php echo $k;?></b>
            </li>            
            <?php }} ?>
                
            </ul>
        <br />
        <hr />
        <?php
        if($verified)
        {
            if(!empty($_POST))
            {
                ?>
                <div class="alert alert-danger">
                    <i class="fa fa-remove"></i>
                    Please fill all required fields.
                </div>
                <?php
            }
            ?>
            <form action="" method="post">
                <div class="col-lg-6">
                    <h3>Admin Access</h3>
                    <div class="form-group">
                        <label>
                            Username:
                        </label>
                        <input type="text" class="form-control" name="username" />
                    </div>           
                    <div class="form-group">
                        <label>
                            Password:
                        </label>
                        <input type="password" class="form-control" name="password" />
                    </div>           
                </div>
                <div class="col-lg-6">
                    <h3>Website Information</h3>
                    <div class="form-group">
                        <label>
                            Website Name:
                        </label>
                        <input type="text" class="form-control" name="website" />
                    </div>           
                    <div class="form-group">
                        <label>
                            Adsense Publish key:
                        </label>
                        <input type="text" class="form-control" name="adsensPublishKey" value="7178474122577413" />
                    </div>           
                    <div class="form-group">
                        
                        
                        <label>
                            Send cards by mail as:
                        </label>
                        <div class="alert alert-warning">
                            (Image or Both) May servers detect the mail as spam
                        </div>
                        
                        <select name="cardsMailFormat" class="form-control">
                            <option value="attachment">Attachment (Recommended)</option>
                            <option value="image">Image</option>
                            <option value="both">Both (Attachment and Image)</option>
                        </select>
                        
                    </div>           
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-gears"></i>
                            Install
                        </button>
                    </div>           
                </div>
            </form>
            <?php
        }
        else
        {
            ?>
            <div class="alert alert-danger">
                <i class="fa fa-remove"></i>
                Please Check the required items above to continue ...
            </div>
            <?php
        }
    }
    ?>
</div>
<?php
include_once 'templates/footer.php';