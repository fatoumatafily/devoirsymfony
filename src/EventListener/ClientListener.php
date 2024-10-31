<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Form\Event\PreSetDataEvent;

final class ClientListener
{
    #[AsEventListener(event: PreSetDataEvent::class)]
    public function onPreSetDataEvent(PreSetDataEvent $event): void
    {
        // ...
    }
}
