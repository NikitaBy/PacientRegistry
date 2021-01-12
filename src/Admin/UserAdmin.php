<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\DoctorProfile;
use App\Entity\User;
use App\Enum\RoleEnum;
use App\Security\UserPasswordUpdater;
use App\Service\ChoiceMapper;
use DateTime;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UserAdmin
 *
 * @method User getSubject()
 */
class UserAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $baseRouteName = 'administration_user_admin';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'administration/user';

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
        if ($user->hasRole(RoleEnum::ROLE_DOCTOR)) {
            $doctorProfile = new DoctorProfile();
            $doctorProfile
                ->setCreatedAt(new DateTime())
                ->
            $user->setDoctorProfile($doctorProfile);
        }
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
            ->with('User')
            ->add('username', null, [])
            ->add('plainPassword', TextType::class, ['required' => false])
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
            )
            ->end();

        $user = $this->getSubject();
        if ($user->getId() && $user->hasRole(RoleEnum::ROLE_DOCTOR)) {
            $form
                ->with('Profile')
                //                                ->add('doctorProfile')
                ->add('doctorProfile.firstName')
                ->add('doctorProfile.patronymic')
                ->add('doctorProfile.lastName')
                ->add('doctorProfile.organization', ChoiceType::class)
                ->end();
        }
    }
}
