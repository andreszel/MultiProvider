<?php

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginCustomAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    public const DASHBOARD_OWNER_ROUTE = 'app_owner_dashboard';
    public const DASHBOARD_CUSTOMER_ROUTE = 'app_customer_dashboard';
    public const DASHBOARD_CLIENT_ROUTE = 'app_client_dashboard';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private EventDispatcherInterface $eventDispatcher,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    )
    {
    }

    public function supports(Request $request): bool
    {
        return !empty($request->getPayload()->get('_username'));
    }

    public function authenticate(Request $request): Passport
    {
        /* $email = $request->request->get('_username', '');
        $password = $request->request->get('_password', '');
        $csrfToken = $request->request->get('_csrf_token', ''); */

        $email = $request->getPayload()->get('_username', '');
        $password = $request->getPayload()->get('_password', '');
        $csrfToken = $request->getPayload()->get('_csrf_token', '');


        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
                (new RememberMeBadge())->enable(),
            ]
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

        /* $request->getSession()->getFlashBag()->add(
            'danger',
            strtr($exception->getMessageKey(), $exception->getMessageData())
        ); */

        return new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response
    {
        $user = $token->getUser();

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        if($user->isOwnerApp()) {
            return new RedirectResponse($this->urlGenerator->generate(self::DASHBOARD_OWNER_ROUTE));
        }
        if($user->isCustomer()) {
            return new RedirectResponse($this->urlGenerator->generate(self::DASHBOARD_CUSTOMER_ROUTE));
        }
        if($user->isClient()) {
            return new RedirectResponse($this->urlGenerator->generate(self::DASHBOARD_CLIENT_ROUTE));
        }

        throw new \Exception('Something went wrong!  '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}