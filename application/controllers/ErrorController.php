<?php
class ErrorController extends Zend_Controller_Action 
{    
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        $exception = $errors->exception;
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found 
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->title   = 'An Error Occured!';
                $this->view->message = 'The page you requested was not found.';

                break;
            case $exception instanceof MyWiki_PermissionDenied_Exception:
                $this->getResponse()->setHttpResponseCode(403);
                $this->view->title   = $exception->getMessage();
            	
            	break;
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->title   = APPLICATION_ENV == 'development'
                	? $exception->getMessage()
                	: 'An unexpected error occurred with your request. Please try again later.';
                	
                $this->view->message = APPLICATION_ENV == 'development'
                	?  $exception->getTraceAsString()
                	: '';
                	
                break;
        }
        $logger = $this->getInvokeArg('bootstrap')->getResource('logger')->getLogger();
		$logger->err($exception->getMessage() . "\n" .  $exception->getTraceAsString());
        $this->getResponse()->clearBody();
    }
}
