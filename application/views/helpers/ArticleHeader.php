<?php

class Zend_View_Helper_Articleheader extends Zend_View_Helper_Abstract
{
	
	public function articleheader()
	{
		$commonStyle = "float: left;
		padding-right: 5px;
		padding-left: 5px;
		border-top: 1px solid #999999;
		";
		$this->view->headStyle(".article_selected {{$commonStyle}\n background-color: #F5F5F5;}");
		$this->view->headStyle(".article_unselected {{$commonStyle}\n background-color: #E0E0E0;\n border-bottom: 1px solid #999999;}");
		
		$headers = array(
			'view' 			=> 'View',
			'viewhistory' 	=> 'View History',
			'edit'			=> 'Edit',
		);
		
		$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
		$out = '';
		$headerCount = count($headers);
		$currentHeader = 0;
		foreach ($headers as $key => &$value) {
			$currentHeader++;
			$css = ($key == $action)?'article_selected':'article_unselected';
			$rightTabStyle = ($currentHeader == $headerCount && $key == $action)?'':'border-right: 1px solid #999999;';
			$out .= sprintf('<div class="%s" style="%s"><a href="%s" style="text-decoration: none;">%s</a></div>',
				$css,
				$rightTabStyle,
				$this->view->url(
					array(
						'controller' => 'article',
						'action' => $key,
						'title' => $this->view->listing->title
					),
					null,
					true),
				$value
			);
		}
		echo '<div><span style="float: left; margin-left: 2px; ">&nbsp;</span>' . $out . '</div>';
	}
}