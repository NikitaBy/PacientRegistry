<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class UserAdmin
 */
class UserAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'admin_administration_user';

    /**
     * @var string
     */
    protected $baseRoutePattern = '/administration/users';

    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add('username');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('username');
    }
}
