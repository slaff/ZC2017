<?php

class default_Model_DbTable_Articles extends Zend_Db_Table_Abstract
{
	protected $_name = 'listings';
	protected $_rowClass = 'default_Model_Article';
	protected $_referenceMap    = array(
        'Owner' => array(
            'columns'           => 'user_id',
            'refTableClass'     => 'default_Model_DbTable_Users',
            'refColumns'        => 'user_id'
        ),
        'Original' => array(
            'columns'           => 'title',
            'refTableClass'     => 'default_Model_DbTable_Articles',
            'refColumns'        => 'title'
        )
    );
}