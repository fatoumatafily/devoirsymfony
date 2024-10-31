<?php

namespace App\Twig\Components;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent(name: 'ClientLiveComponent')]
final class ClientLiveComponent extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?bool $choice = null;

    // public function __construct(Client $client)
    // {
    // }

    // #[LiveProp]
    // private ?Client $client = null;

    protected function instantiateForm(): FormInterface
    {
        
        // Récupération du client à modifier ou création d'un nouveau client si null
        return $this->createForm(ClientType::class);
    }

    public function getForm(): FormInterface
    {
        return $this->instantiateForm();
    }
}
