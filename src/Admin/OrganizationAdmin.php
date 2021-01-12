<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class OrganizationAdmin
 */
class OrganizationAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'administration_organization';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'administration/organization';

    /**
     * @param ListMapper $list
     *
     * @return void
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('name')
            ->add('description');
    }

    /**
     * @param FormMapper $form
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('name')
            ->add('description');
    }
}
