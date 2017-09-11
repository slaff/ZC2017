<?php

/**
 * MyWiki_Log
 *
 * Logs all messages to a log file
 * path to log file defined in configs
 * 
 */
class MyWiki_Resource_Logger extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * 
	 * @var Zend_Log
	 */
    protected $_log = null;
    
    public function init()
    {
    	return $this;
    }
    
    /**
     * 
     * @return Zend_Log
     */
    
    public function getLogger()
    {
        if ($this->_log === NULL) {
        	$options = $this->getOptions();
            $logFile    = $options['logs'] . date( 'Ymd') . '_' . $options['filename'];
            $writer     = new Zend_Log_Writer_Stream($logFile);
            $this->_log = new Zend_Log($writer);            
        }
        
        return $this->_log;
    }
}
