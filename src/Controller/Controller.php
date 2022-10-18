<?php

namespace Atournayre\Helper\Controller;

use Atournayre\EntityValidation\EntityValidationHelper;
use Atournayre\Helper\TypedException;
use Atournayre\Helper\FlashMessageHelper;
use Atournayre\Helper\Service\FlashService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Controller extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var FlashService
     */
    private $flashService;

    public function __construct(
        LoggerInterface $logger,
        FlashService $flashService
    )
    {
        $this->logger = $logger;
        $this->flashService = $flashService;
    }

    public function messageSucces(string $message)
    {
        $this->addFlash(FlashMessageHelper::TYPE_SUCCESS, $message);
    }

    public function messageInfo(string $message)
    {
        $this->addFlash(FlashMessageHelper::TYPE_INFO, $message);
    }

    public function messageAlerte(string $message)
    {
        $this->addFlash(FlashMessageHelper::TYPE_WARNING, $message);
    }

    public function messageAlerteFormulaireInvalide(string $message = null)
    {
        $this->addFlash(FlashMessageHelper::TYPE_WARNING, $message ?? FlashMessageHelper::MESSAGE_ERREUR_FORMULAIRE);
    }

    public function messageErreur(string $message)
    {
        $this->addFlash(FlashMessageHelper::TYPE_DANGER, $message);
    }

    public function messageDepuisException(TypedException $exception)
    {
        $this->flashService->addFromException($exception);
    }

    public function loggerErreur(string $message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    public function loggerException(\Exception $exception)
    {
        $this->logger->error($exception->getMessage(), $exception->getTrace());
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function renderErreur(string $messageErreur): Response
    {
        if (!$this->container->has('twig')) {
            throw new \LogicException('The Twig Bundle is not available. Try running "composer require symfony/twig-bundle".');
        }

        /** @var Environment $twig */
        $twig = $this->container->get('twig');

        $template = 'erreur/index.html.twig';

        if (!$twig->getLoader()->exists($template)) {
            throw new \LogicException(sprintf('Template "%s" was not found. Create it to use %s.', $template, __METHOD__));
        }

        return $this->render($template, [
            'message' => $messageErreur,
        ]);
    }

    public function jsonErreur(string $messageErreur, int $status = 200, array $headers = [], array $context = []): Response
    {
        return $this->json([
            'type' => 'error',
            'message' => $messageErreur,
        ], $status, $headers, $context);
    }

    public function jsonSuccess(string $messageSucces, array $data): Response
    {
        return $this->json([
            'type' => 'success',
            'message' => $messageSucces,
            'data' => $data,
        ]);
    }

    public function validateForm(FormInterface $form)
    {
        if (!class_exists(EntityValidationHelper::class)) {
            throw new \LogicException('EntityValidationHelper component is not available. Try running "composer require atournayre/entity-validation".');
        }

        EntityValidationHelper::form($form);
    }
}
