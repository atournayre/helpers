<?php

namespace Atournayre\Helper\Subscriber\Form;

use Atournayre\Helper\Decorator\Form\MaxLengthFormDecorator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FormDecoratorSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        MaxLengthFormDecorator::decorate($form);
    }
}
