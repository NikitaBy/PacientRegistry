<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\DoctorProfile;
use App\Entity\User;
use App\Factory\DoctorProfileFactory;
use App\Security\UserPasswordUpdater;
use DateTime;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Security;

/**
 * Class DoctorProfileAdmin
 */
class DoctorProfileAdmin extends AbstractAdmin
{
    /**
     * @var DoctorProfileFactory
     */
    private $doctorProfileFactory;

    /**
     * @var UserPasswordUpdater
     */
    private $passwordUpdater;

    /**
     * @var Security
     */
    private $security;

    public function __construct(
        $code,
        $class,
        $baseControllerName,
        DoctorProfileFactory $doctorProfileFactory,
        Security $security,
        UserPasswordUpdater $passwordUpdater
    ) {
        parent::__construct($code, $class, $baseControllerName);

        $this->doctorProfileFactory = $doctorProfileFactory;
        $this->security = $security;
        $this->passwordUpdater = $passwordUpdater;
    }

    public function getNewInstance()
    {
        return $this->doctorProfileFactory->create();
    }

    /**
     * @param DoctorProfile $object
     *
     * @return void
     */
    public function prePersist($object): void
    {
        /** @var User $createdBy */
        $createdBy = $this->security->getUser();

        $object
            ->setCreatedAt(new DateTime())
            ->setCreatedBy($createdBy);

        $this->passwordUpdater->updatePassword($object->getUser());
    }

    /**
     * @param DoctorProfile $object
     *
     * @return void
     */
    public function preUpdate($object): void
    {
        /** @var User $updatedBy */
        $updatedBy = $this->security->getUser();

        $object->setUpdatedBy($updatedBy);

        $this->passwordUpdater->updatePassword($object->getUser());
    }

    /**
     * @param FormMapper $form
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('user.username')
            ->add('user.plainPassword', TextType::class, ['required' => false])
            ->add('firstName')
            ->add('patronymic')
            ->add('lastName')
            ->add('organization');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add('lastName')
            ->add('firstName')
            ->add(
                '_action',
                null,
                ['actions' => ['edit' => [], 'delete' => []]]
            );
    }
}
