<?php

class MyLogger
{
    private $log_path;

    function __construct($log_path)
    {
        $this->log_path = $log_path;
    }

    public function WriteLog(mixid $message, string $log_type) #Logtype: warning, error;
    {
        $template_log = "[#TIME#][#LOG_TYPE#} > #MESSAGE#\n";

        if(is_array($message))
        {
            $message = var_export($message, true);
        }
        elseif (is_string($message)) 
        {
        
        }
        else 
        {
            return;        
        }

        $ptr = Array("#TIME#", "#LOG_TYPE#", "#MESSAGE#");

        $rep = Array(date('l js \of F Y h:i:s A'), $log_type, $message);

        $info = str_replace($ptr, $rep, $template_log);

        file_put_content($this->log_path, $info, FILE_APPEND | LOCK_EX);
    }

    public function ReadLog()
    {
        return file_get_contents($this->log_path);
    }
}
