<?php
class default_Form_Article extends Zend_Form
{
    public function init()
    {
        $this->addElement('textarea', 'content', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
        ));

        $this->addElement('submit', 'Create', array(
            'size'   => 10,
            'label'  => 'Create',
            'ignore' => true,
        ));
    }
}
