<?php 
$_v = 1.5;
function getExt($name, $withRealName = false)
{
    $name = explode(".", $name);            
    $ext = end($name);
    unset($name[count($name) - 1]);
    $name = implode(".", $name);
    $ext = strtolower($ext);
    
    return $withRealName ? (object) array('ext' => $ext, 'name' => $name) : $ext;
}

function listing($Notconfigured = false)
{
    $path = $GLOBALS['config']['dir'].'/';
    $dir = opendir($path);
    $imgs = array('jpg', 'jpeg', 'png', 'gif');
    $files = array();
    if($Notconfigured && !isAdmin) $Notconfigured = false;
    while(($file = readdir($dir)) !== false)
    {
        if(is_file($path.$file))
        {
            $n = getExt($file, true);
            $name = $n->name;
            $ext = $n->ext;            
            $isDetails = file_exists($path.$file.'.json');
            if(in_array($ext, $imgs) && ($isDetails || isAdmin) && ((!$isDetails && $Notconfigured) || !$Notconfigured))
            {                
                $details = $isDetails ? @file_get_contents($path.$file.'.json') or '{}' : '{}';
                $details = json_decode($details);
                $files[] = (object) ['name' => $file, 'fullPath' => $path.$file, 
                    'details' => $details, 'sample' => $path.'samples/'.$file, 'isDetails' => $isDetails];                
            }
        }
    }
    return $files;
}

function redirect($url = '')
{
    ?>
    <script type="text/javascript">
        window.location.href = '<?php echo $url; ?>';
    </script>        
    <?php
    exit;
}

function checkAdmin()
{
    if(!isAdmin)
    {
        redirect('index.php');
    }
    else return true;
}

function run()
{
    $p = !empty($_GET['p']) ? $_GET['p'] : null;
    switch($p)
    {
        case 'show':            
            include 'editor.php';
            view();
            break;
        case 'new':
            checkAdmin();
            include 'editor.php';
            upload();
            break;
        case 'edit':
            checkAdmin();
        case 'view':        
            if(!empty($_GET['photo']) && file_exists($GLOBALS['config']['dir'].'/'.$_GET['photo']))
            {
                include 'editor.php';
                show();
                break;
            }
        case 'delete':
            if(!empty($_GET['photo']) && isAdmin && !demoMode)
            {
                $del = @unlink($GLOBALS['config']['dir'].'/'.$_GET['photo']);
                if($del)
                {                    
                    @unlink($GLOBALS['config']['dir'].'/'.$_GET['photo'].'.json');
                }
                
                redirect('index.php');
            }
            elseif(isAdmin && demoMode) showDemoMode ();
        default;
            $files = listing();
            include 'templates/listing.php';            
    }
    if(!isAdmin)
    {
        include_once 'templates/login.php';
        ?>
        <script type="text/javascript">
            function login()
            {
                $('#login-temp').modal('show');
            }
        </script>
        <?php
    }
}

function echoJson($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sitePath($url = '')
{
    
    $path = $_SERVER['PHP_SELF'];
    $path = substr($path, 0, strlen($path) - strlen(basename($path)));
    return (!empty($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : (!empty($_SERVER['HTTPS']) ? 'https' : 'http')).'://'.serverName().$path.$url;
}

function serverName()
{
    return (!empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
}

function currentURL()
{
    return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

function file_upload_max_size() 
{
    static $max_size = -1;

    if ($max_size < 0) {
        // Start with post_max_size.
        $post_max_size = parse_size(ini_get('post_max_size'));
        if ($post_max_size > 0) {
            $max_size = $post_max_size;
        }

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $upload_max = parse_size(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
    }
    return $max_size;
}

function parse_size($size) 
{
    $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
    $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
    if ($unit) 
    {
        // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
        return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
    } 
    else 
    {
        return round($size);
    }
}

function clearParam($v)
{
    return str_replace("'", "`", urldecode($v));
}