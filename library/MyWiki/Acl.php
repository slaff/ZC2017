<?php
/**
 * This file defines Access Controls for the WIKI application.
 * The application basically has only two types of users
 * Administrator and WIKI user
 * A Guest is allowed to view, create new articles and edit existing articles.
 * While the Administrator can additionally create new WIKI Users 
 */

class MyWiki_Acl extends Zend_Acl
{
    public function __construct()
    {
        try {
            // Define Roles guest, user and publisher
            $this->addRole(new Zend_Acl_Role('guest'))
                 ->addRole(new Zend_Acl_Role('user'))
                 ->addRole(new Zend_Acl_Role('admin'));

            // array of defined roles - the order in which they appear is important
            $parents = array('guest', 'user', 'admin');

            $this->addRole(new Zend_Acl_Role('Guest'), $parents);

            // Define role for a user zend - the publisher in our application
            $this->addRole(new Zend_Acl_Role('zenduser'), $parents);

            // Define role for a user zend - the publisher in our application
            $this->addRole(new Zend_Acl_Role('administrator'), $parents);

            // define resources
            $this->add(new Zend_Acl_Resource('article'));

            // Assign access control for the resources
            // Guest user only has view privileges
            $this->allow('Guest', 'article', 'view');

            // the user zenduser can view, edit, create - role assertions
            // null indicates that the allow rules apply to all resources
            $this->allow('zenduser', 'article', array('view', 'create', 'edit'));

            // The user Administrator has access to all resources
            $this->allow('administrator');
        } catch (Zend_Acl_Exception $e) {
            MyWiki_Log::getLogger()->err($e->getMessage());
            throw $e;
        }
    }
}
