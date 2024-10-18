<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Form\DetteType;
use App\Repository\ClientRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'dettes.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dette/index.html.twig', [
            'controller_name' => 'DetteController',
        ]);
    }

    #[Route('/dette/details/{id}?', name: 'dettes.details', methods: ['GET', 'POST'])]
    public function show(EntityManagerInterface $entityManager, DetteRepository $detteRepository, ClientRepository $clientRepository, int $id, Request $request): Response
    {
        // Création du formulaire dette
        $dette = new Dette();
        $detteForm = $this->createForm(DetteType::class, $dette);
        $detteForm->handleRequest($request);
        // Récupération des dettes d'un client
        $dettes = $detteRepository->findBy(['client' => $id]);
        // Récupération du client
        $client = $clientRepository->find($id);

        // Enregistrer la dette si le formulaire est soumis et valide
        if ($detteForm->isSubmitted() && $detteForm->isValid()) {
            // Associer la dette au client
            $dette->setClient($client);
            // Enregistrer la dette en base de données
            $entityManager->persist($dette);
            $entityManager->flush();
            // Rediriger après l'enregistrement
            return $this->redirectToRoute('dettes.details', ['id' => $id]);
        }

        return $this->render('dette/show.html.twig', [
            'controller_name' => 'DetteController',
            'datas' => $dettes,
            'detteForm' => $detteForm->createView(),
            'client' => $client
        ]);
    }
}
