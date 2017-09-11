<?php

class default_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
	protected $_name = 'wikiusers';
	protected $_rowClass = 'default_Model_User';
	
	protected $_referenceMap    = array(
        'LastModified' => array(
            'columns'           => 'user_id',
            'refTableClass'     => 'default_Model_DbTable_Articles',
            'refColumns'        => 'user_id'
        )
    );
	
}