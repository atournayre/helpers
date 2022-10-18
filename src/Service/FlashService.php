<?php

namespace Atournayre\Helper\Service;

use Atournayre\Helper\TypedException;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;

class FlashService
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param TypedException $exception
     *
     * @return void
     * @throws \LogicException
     */
    public function addFromException(TypedException $exception)
    {
        $this->add($exception->getType(), $exception->getMessage());
    }

    /**
     * Adds a flash message to the current session for type.
     *
     * @param string $type
     * @param string $message
     *
     * @return void
     * @throws \LogicException
     */
    protected function add(string $type, string $message)
    {
        try {
            $this->requestStack->getSession()->getFlashBag()->add($type, $message);
        } catch (SessionNotFoundException $e) {
            throw new \LogicException('You cannot use the addFlash method if sessions are disabled. Enable them in "config/packages/framework.yaml".', 0, $e);
        }
    }
}
