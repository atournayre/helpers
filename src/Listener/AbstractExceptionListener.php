<?php

namespace Atournayre\Helper\Listener;

use Atournayre\Helper\Exception\TypedException;
use Atournayre\Helper\Service\FlashService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Routing\RouterInterface;
use Throwable;

abstract class AbstractExceptionListener
{
    protected Throwable $throwable;

    public function __construct(
        private readonly RouterInterface $router,
        private readonly FlashService    $flashService,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $this->throwable = $event->getThrowable();
    }

    abstract public function redirectResponseVersPageDeLogin(ExceptionEvent $event): void;

    abstract public function redirectResponseVersPageDAccueil(ExceptionEvent $event): void;

    protected function redirectResponseVersRoute(
        string         $route,
        array          $routeParameters = [],
    ): RedirectResponse {
        return (new RedirectResponse($this->router->generate($route, $routeParameters)))
            ->setStatusCode(302);
    }

    protected function informerLUtilisateurEtRedirigerVersRoute(
        ExceptionEvent $event,
        string         $route,
        array          $routeParameters = [],
    ): void {
        if ($this->throwable instanceof TypedException) {
            $this->flashService->addFromException($this->throwable);
        }

        $response = $this->redirectResponseVersRoute($route, $routeParameters);
        $event->setResponse($response);
    }
}
