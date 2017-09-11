<?php

class IndexController extends Zend_Controller_Action 
{
    public function indexAction() 
    {
        $articleTable = new default_Model_DbTable_Articles();
        $t = $articleTable->fetchNew();
        $this->view->listings = array();
        $stmt = $articleTable
        			->select()
        			->group('title')
        			->order('modified DESC')
        			->query();
        $stmt->execute();
        while (($obj = $stmt->fetchObject('default_Model_Article')) !== false) {
        	$this->view->listings[] = $obj;
        }
    }
}
