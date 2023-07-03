<? 
class AppConfig 
{ 
    private static $config = array();  
    
    public static function setConfig($id, $value) 
    { 
        self::$config[$id] = $value;  
    }

    public static function getConfig($valID) 
    { 
        return isset(self::$config[$valID]) ? self::$config[$valID] : null;  
    }
}


global $cfg; 
$cfg = new AppConfig(); 


$cfg::setConfig('fileExtensionsDeny', array(
    'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp', 
    'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html', 
    'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi', 'exe'
   )
); 

$cfg::setConfig('maxFileSize', 8); // В мегабайтах