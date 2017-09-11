<?php
class default_Form_ArticleEdit extends Zend_Form
{
    public function init()
    {
        $this->addElement('textarea', 'content', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
        ));

        $this->addElement('submit', 'Save', array(
            'size'   => 10,
            'label'  => 'Save',
            'ignore' => true,
        ));
    }
}
