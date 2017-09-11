<?php
class Zend_View_Helper_MenuLeft extends Zend_View_Helper_Abstract
{
	public function menuLeft() 
	{
		$urlMain = $this->view->url(array('controller' => 'index', 'action' => 'index'), null, true);
		$urlRecent = $this->view->url(array('controller' => 'recent-changes', 'action' => 'index'), null, true);
		$urlHelp = $this->view->url(array('controller' => 'help', 'action' => 'index'), null, true);
		
        $menuLeftHtml = <<<EOQ
		<div id="wiki-left-menu">
			<ul>
				<li><a href="{$urlMain}">Main Page</a> </li>
				<li><a href="{$urlRecent}">Recent Changes</a></li>
				<li><a href="{$urlHelp}">Help</a></li>			
			</ul>
		</div>
EOQ;

        return $menuLeftHtml;
    }
}
