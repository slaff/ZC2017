<?php
class Zend_View_Helper_MenuBar extends Zend_View_Helper_Abstract
{
    public function menuBar() 
	{
        if (!$this->view->isArticle) {
            return '';
        }

		$urlHome   = $this->view->urlHome;
		$pageTitle = urlencode($this->view->pageTitle);
		
        $menuBarHtml = <<<EOQ
<div id="wiki-top-menu">
	<a href="$urlHome/article/edit/title/$pageTitle">edit article</a> 
	<a href="$urlHome/article/view-history/title/$pageTitle">history </a>
</div>
<div class="clear"></div>
EOQ;

        return $menuBarHtml;
    }
}
