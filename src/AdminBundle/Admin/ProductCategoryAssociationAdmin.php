<?php

namespace AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class ProductCategoryAssociationAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('category', 'entity',
            [
                'class' => 'AppBundle\Entity\Category',
                'property' => 'name',
            ]
        )
            ->add(
                'product', 'entity',
                [
                    'class' => 'AppBundle\Entity\Product',
                    'property' => 'name',
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('category.name')->add('product.name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('category.name')->addIdentifier('product.name');
    }
}