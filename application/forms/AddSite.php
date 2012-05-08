<?php

class Application_Form_AddSite extends Zend_Form
{

    public function init()
    {
        $this->setName('AddSite');
        $this->setMethod('post');

        $this->addElement('text', 'url', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'required'   => true,
            'label'      => 'Wordpress site URL:',
        ));


        $this->addElement('text', 'username', array(
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Username:',
        ));

        $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Password:',
        ));

        $this->addElement('submit', 'save', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Save',
        ));

    }


}