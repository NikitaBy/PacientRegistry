<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 */
class SecurityController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * LoginController constructor.
     *
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="admin_login")
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(
            LoginForm::class,
            [
                'email' => $this->authenticationUtils->getLastUsername(),
            ]
        );

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $this->authenticationUtils->getLastUsername(),
                'form'          => $form->createView(),
                'error'         => $this->authenticationUtils->getLastAuthenticationError(),
            ]
        );
    }

    /**
     * @Route("logout", name="admin_logout")
     */
    public function logoutAction(): void
    {
    }
}
