<?php
class HelpController extends Zend_Controller_Action 
{
    public function indexAction() 
    {
    	global $$topics->forLoading;
    	
    	$topic = $this->getRequest()->getUserParam("topic");
    	$this->view->assign("topic", $$topics['help'][$topic]);
    }
}
