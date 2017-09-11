<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoload()
	{
		Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
		
		return new Zend_Application_Module_Autoloader(
			array(
				'namespace'	=> 'default',
				'basePath'	=> dirname(__FILE__)
				)
			);
	}

}

