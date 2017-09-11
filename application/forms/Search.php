<?php
class default_Form_Search extends Zend_Form
{
    public function init()
    {
        $this->addElement('text', 'title', array(
            'size'      => 18,
            'maxlength' => 120,
            'decorators' => array(
                'ViewHelper',
            ),
        ));

        $this->addElement('submit', 'Search', array(
            'label'  => 'Search',
            'size'   => 10,
            'ignore' => true,
            'decorators' => array(
                'ViewHelper',
            ),
        ));

        $this->setMethod('get');

        $this->setDecorators(array(
            'FormElements',
            'Form',
        ));
    }
}
