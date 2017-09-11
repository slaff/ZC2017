<?php
class Zend_View_Helper_Header extends Zend_View_Helper_Abstract
{
    public function header() 
    {
   	
        $auth     = Zend_Auth::getInstance();
        $username = 'Guest';
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->username;
        }

        $applicationName = $this->view->applicationName;

        $welcome         = 'Welcome <span class="bold">' . $username . '</span>';
        
        if ($username != 'Guest') {
            $welcome .= ' - <a href="' 
            	. $this->view->url(
            		array (
            			'controller' 	=> 'user',
            			'action'		=> 'logout'
            			)
            		)
            	. '">logout</a>';    
        } else {
            $welcome .= ' - <a href="' 
            	. $this->view->url(
            		array (
            			'controller' 	=> 'user',
            			'action'		=> 'login'
            			)
            		)
            	. '">login</a>';    
        }
        
        $headerHtml = <<<EOQ
<div id="header">
    <a href="/">Home</a> | $welcome
    <h1>$applicationName  
        <a href="http://framework.zend.com/" target="zfwindow">
            <img src="/images/PoweredBy_ZF_4LightBG.png" border="0">
        </a>
    </h1>        
</div>
EOQ;

        return $headerHtml;
    }
}
