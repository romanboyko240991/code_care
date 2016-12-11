<?php

namespace AdminBundle\Admin;

use AdminBundle\AdminBundle;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('username', 'text');

        if (strlen($this->getSubject()->getUsername()) == 0) {
            $formMapper->add('password', 'text');
        }

        $formMapper->add('email', 'text')
            ->add('isAdmin', 'checkbox', ['required' => false, 'label' => 'Is user Administrator?'])
            ->add('isActive', 'checkbox', ['required' => false, 'label' => 'Activate user?']);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('username')->add('email');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('username')->addIdentifier('email')->addIdentifier('isAdmin');
    }

    public function postPersist($object)
    {
        $object->setPassword(password_hash($object->getPassword(), PASSWORD_BCRYPT));

        $em = AdminBundle::getContainer()->get('doctrine')->getManager();

        $em->persist($object);
        $em->flush();
    }
}