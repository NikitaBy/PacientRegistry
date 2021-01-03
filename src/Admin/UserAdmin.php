<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Security\UserPasswordUpdater;
use App\Service\ChoiceMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UserAdmin
 */
class UserAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'user_admin';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'user';

    /**
     * @var ChoiceMapper
     */
    private $choiceMapper;

    /**
     * @var UserPasswordUpdater
     */
    private $passwordUpdater;

    public function __construct(
        $code,
        $class,
        $baseControllerName,
        ChoiceMapper $choiceMapper,
        UserPasswordUpdater $passwordUpdater
    ) {
        parent::__construct($code, $class, $baseControllerName);

        $this->choiceMapper = $choiceMapper;
        $this->passwordUpdater = $passwordUpdater;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function prePersist($user): void
    {
        $this->passwordUpdater->updatePassword($user);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function preUpdate($user): void
    {
        $this->passwordUpdater->updatePassword($user);
    }

    /**
     * @param ListMapper $list
     *
     * @return void
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('username')
            ->add('roles')
            ->add('_action', null, ['actions' => ['edit' => [], 'delete' => []]]);
    }

    /**
     * @param FormMapper $form
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('username', null, [])
            ->add('plainPassword', TextType::class)
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices'                   => $this->choiceMapper->map(
                        'choices.roles.',
                        RoleEnum::listForChoice()
                    ),
                    'choice_translation_domain' => $this->getTranslationDomain(),
                    'multiple'                  => true,
                ]
            );
    }
}
