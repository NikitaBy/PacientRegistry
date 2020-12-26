<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Form\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

/**
 * Class LoginAuthenticator
 */
class LoginAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * LoginAuthenticator constructor.
     *
     * @param FormFactoryInterface         $formFactory
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param RouterInterface              $router
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router
    ) {
        $this->formFactory = $formFactory;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
    }

    public function supports(Request $request): bool
    {
        return !($request->getPathInfo() !== '/admin/login' || $request->getMethod() !== 'POST');
    }

    public function getCredentials(Request $request): array
    {
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['username']
        );

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        if (!$this->passwordEncoder->isPasswordValid($user, $credentials['password'])) {
            return false;
        }

        /** @var User $user */
        if ($user->isSuspended()) {
            throw new CustomUserMessageAuthenticationException('Suspended');
        }

        if (!$user->hasRole(RoleEnum::ROLE_ADMIN)) {
            throw new CustomUserMessageAuthenticationException("You don't have permission to access that page.");
        }

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): RedirectResponse
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        return new RedirectResponse($this->router->generate('admin_login'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('sonata_admin_dashboard'));
    }

    protected function getLoginUrl(): RedirectResponse
    {
        return new RedirectResponse($this->router->generate('admin_login'));
    }
}
