<?php

class ArticleController extends Zend_Controller_Action
{

    public function viewAction()
    {
    	$articleTable = new default_Model_DbTable_Articles();
        $request      = $this->getRequest();
        $title        = $request->getParam('title');

        if (empty($title)) {
            $this->_redirect('/');
            return;
        }

        $this->view->pageTitle = $title;

        if ($request->getParam('id')) {
            $listingId = $request->getParam('id');
            $listing   = $articleTable->find($listingId);
        } else {
            $listing = $articleTable
            	->select()
            	->where('title = ?', $title)
            	->order('modified DESC')
            	->limit(1)
            	->query()
            	->fetchObject('default_Model_Article');
        }
        
        if ($listing) {
        	$this->view->lastModified 	= $listing->finddefault_Model_DbTable_UsersByLastModified()->current();
        	$originalListing = $listing->finddefault_Model_DbTable_ArticlesByOriginal()->current();
        	$this->view->owner 			= $originalListing->finddefault_Model_DbTable_UsersByLastModified()->current();
            $this->view->listing 		= $listing;
        } else {
        	$this->_forward('newarticle');
        }
    }
    
    public function newarticleAction()
    {
		
        $title = $this->_request->getParam('title');
        if ($this->_checkAcl($title)) {
        	$form = new default_Form_Article();
        	if ($this->_request->isPost()) {
        		if ($form->isValid($this->_request->getPost())) {
        			$articleTable = new default_Model_DbTable_Articles();
        			$article = $articleTable->fetchNew();
        			$article->content = $form->getValue('content');
        			$article->title = $title;
        			$article->modified = time();
        			$article->user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
        			$article->save();
        			$this->_forward('view', 'article', null, array('title' => $title));
        			return;        			
        		}
        	}
	    	$url = $this->view->url(
	            array(
	            	'controller'	=> 'article',
	            	'action'		=> 'newarticle',
	            	'title'			=> $title
	            )
			);
            $form->setAction($url);
    		$this->view->form = $form;
        }
    	
    }

    public function viewhistoryAction()
    {    
        
        $title        = $this->_request->getParam('title');
        $title        = urldecode($title);

        if (empty($title)) {
            return $this->_redirect('/');
        }

        $this->view->pageTitle = $title;
        $history = array();
        $historyOwner = array();
        $articleTable = new default_Model_DbTable_Articles();
        $stmt = $articleTable
		            ->select()
		            ->where('title = ?')
		            ->order('modified DESC')
		            ->query();
		$stmt->execute(array($title));
		$this->view->listing = null;
        while (($obj = $stmt->fetchObject('default_Model_Article')) !== false) {
//        	$rs = 
//        	$obj->real_name = $rs->current()->real_name;
        	$this->view->listing = $history[] = $obj;
        	
        }
        
        if ($history) {
            $this->view->history = $history;
        }
    }

    public function editAction()
    {
        if (!$title = $this->_getTitle()) {
            return;
        }

        // Enforcing access control here
        if (!$this->_checkAcl($title)) {
            return;
        }

        // Validate form
        $form    = new default_Form_ArticleEdit();
        $form->setMethod('post')
    		->setAction($this->view->url());
        
        $request = $this->getRequest();
        if (!$request->isPost() || !$form->isValid($request->getPost())) {
            // Failed validation; redisplay form
			$articleTable = new default_Model_DbTable_Articles();
            $listing = $articleTable
            	->select()
            	->where('title = ?', $title)
            	->order('modified DESC')
            	->limit(1)
            	->query()
            	->fetchObject('default_Model_Article');
            	
            if (!$listing) {
                // Attempted to submit an edit form for a new article
                throw new MyWiki_Exception('Cannot edit entries that do not exist');
            }
            if (!$request->isPost()) {
            	$form->getElement('content')->setValue($listing->content);
            }
            $this->view->form        = $form;
            $this->view->pageTitle   = $title;
            $this->view->listing    = $listing;
            
            return;
        }

		$articleTable = new default_Model_DbTable_Articles();
        $article = $articleTable->fetchNew();
        $article->content = $form->getValue('content');
        $article->title = $title;
        $article->user_id = Zend_Auth::getInstance()->getIdentity()->user_id;
		$article->modified = time();
		
        // Insert the new article
        $article->save();
        
        return $this->_forward('view', 'article', null, array('title' => $title));
        
    }

    protected function _getTitle()
    {
        $title = urldecode($this->getRequest()->getParam('title', ''));
        if (empty($title)) {
            $this->_redirect('/');
            return false;
        }
        return $title;
    }

    protected function _checkAcl($title)
    {
        $username = 'Guest';
        $auth     = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $username = $auth->getIdentity()->username;
        }
        $acl      = new MyWiki_Acl();
        if (!$acl->isAllowed($username, 'article', 'create')) {
            if ('view' != $this->getRequest()->getActionName()) {
                throw new MyWiki_PermissionDenied_Exception('You need to be logged in to create and edit pages!');
                $this->_forward('view', 'article', null,array('title' => $title));
            }
            return false;
        }
        return true;
    }

}
