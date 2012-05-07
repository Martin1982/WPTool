<?php

class Application_Form_AddSite extends Zend_Form
{

    public function init()
    {
        $this->setName('AddSite');
        $this->setMethod('post');

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
        ));

    }


}