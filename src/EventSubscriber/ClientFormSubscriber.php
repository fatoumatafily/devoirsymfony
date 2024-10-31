<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Form\UserType;

class ClientFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        // S'assurer que $data n'est pas null avant de vérifier 'utilisateur'
        if ($data && $data->getUtilisateur()) {
            $form->add('utilisateur', UserType::class, [
                'required' => false,
                'label' => false,
            ]);
        }
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        // Vérifier si 'utilisateur' est défini et s'il contient des données valides
        if (isset($data['utilisateur']) && !empty(array_filter($data['utilisateur']))) {
            $form->add('utilisateur', UserType::class, [
                'required' => false,
                'label' => false,
            ]);
        }
    }
}
