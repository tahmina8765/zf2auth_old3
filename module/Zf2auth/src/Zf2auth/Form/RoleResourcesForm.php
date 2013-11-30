<?php
namespace Zf2auth\Form;

use Zend\Form\Form;
use \Zend\Form\Element;

class RoleResourcesForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('role_resources');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('method', 'post');



        
        $id = new Element\Hidden('id');
        $id->setAttribute('class', 'primarykey');

        $csrf = new Element\Csrf('csrf');
        $csrf_options  = array (
            'csrf_options' => array (
                'timeout' => 1000
            )
        );
        $csrf->setOptions($csrf_options);
    
	
        $role_id = new Element\Text('role_id');
        $role_id->setLabel('Role Id')
                ->setAttribute('class', 'required form-control')
                ->setAttribute('id', 'role_id')
                ->setAttribute('placeholder', 'Role Id');
        

        $resource_id = new Element\Text('resource_id');
        $resource_id->setLabel('Resource Id')
                ->setAttribute('class', 'required form-control')
                ->setAttribute('id', 'resource_id')
                ->setAttribute('placeholder', 'Resource Id');
        



        $submit = new Element\Submit('submit');
        $submit->setValue('Submit')
                ->setAttribute('class', 'btn btn-primary');

        $this->add($id);
        $this->add($csrf);
        $this->add($role_id);
	$this->add($resource_id);
	


    }
}


    