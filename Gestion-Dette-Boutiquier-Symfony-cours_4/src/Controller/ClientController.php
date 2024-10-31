<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Client;
use App\Form\ClientType;
use App\Form\ClientSearchType;
use App\Form\SearchClientType;
use App\Entity\ClientSearchDTO;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Twig\Components\ClientLiveComponent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'clients.index', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function index(ClientRepository $clientRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');
        // Formulaire de recherche mapping à un Entité
        $searchDTO = new ClientSearchDTO();
        $searchForm = $this->createForm(ClientSearchType::class, $searchDTO);
        $searchForm->handleRequest($request);

        // Formulaire de recherche non mapping à un Entité
        // $searchForm = $this->createForm(SearchClientType::class);
        // $searchForm->handleRequest($request);

        // Pagination
        $page = $request->query->getInt(key: 'page', default: 1);
        $limit = 5; // Nombre d'éléments par page

        // Récupération des clients (avec ou sans recherche)
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            // Recherche avec mapping Entity
            $clients = $clientRepository->searchBySurnameOrTel(
                $searchDTO->getSearchTerm(),
                $page,
                $limit
            );
            $totalClients = $clientRepository->countSearchResults($searchDTO->getSearchTerm());
            
            // Recherche sans mapping Entity
            // $clients = $clientRepository->searchBySurnameOrTel(
            //     $searchForm->get('tel')->getData(),
            //     $page,
            //     $limit
            // );
            // $totalClients = $clientRepository->countSearchResults($searchForm->get('tel')->getData());
        } else {
            $clients = $clientRepository->findBy([], ['createAt' => 'DESC'], $limit, ($page - 1) * $limit);
            $totalClients = $clientRepository->count([]);
        }

        $maxPages = ceil($totalClients / $limit);

        // Formulaire de création de client
        $newClient = new Client();
        $clientForm = $this->createForm(ClientType::class, $newClient);
        $clientForm->handleRequest($request);
        // $liveComponent = new ClientLiveComponent();
        // $clientForm = $liveComponent->getForm();
        // $newClient = $liveComponent->getClient();

        if ($clientForm->isSubmitted() && $clientForm->isValid()) {
            if ($clientForm->get('choice')->getData()) {
                $user = new User();
                $user->setEmail($clientForm->get('utilisateur')->get('email')->getData());
                $user->setLogin($clientForm->get('utilisateur')->get('login')->getData());
                $user->setPassword($clientForm->get('utilisateur')->get('password')->getData());
                $newClient->setUtilisateur($user);
                $entityManager->persist($user);
            } else {
                $newClient->setUtilisateur(null);
            }
            
            $entityManager->persist($newClient);
            $entityManager->flush();
            return $this->redirectToRoute('clients.index');
        }

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'searchForm' => $searchForm->createView(),
            'clientForm' => $clientForm->createView(),
            'datas' => $clients,
            'currentPage' => $page,
            'maxPages' => $maxPages,
        ]);
    }
}