<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Dette;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {


        // Création de 50 clients
        for ($i = 0; $i < 50; $i++) {
            $client = new Client();
            $client->setSurname('Client' . ($i + 1));
            $client->setTel('010000000' . ($i + 1));
            $client->setAddress('HLM ' . ($i + 1));
            $client->setCumulMontantDu(($i * 2.5));
            $client->setCreateAt(new \DateTimeImmutable());
            $client->setUpdateAt(new \DateTimeImmutable());
            $client->setStatus(true);

            // Création de utilisateurs si c'est pair
            if ($i % 2 == 0) {
                $user = new User();
                $user->setEmail('utilisateur' . ($i + 1) . '@gmail.com');
                $user->setLogin('Utilisateur' . ($i + 1));
                $plaintextPassword = 'passer' . ($i + 1);

                // hash the password (based on the security.yaml config for the $user class)
                $hashedPassword = $this->encoder->hashPassword(
                    $user,
                    $plaintextPassword
                );
                $user->setPassword($hashedPassword);
                $user->setCreateAt(new \DateTimeImmutable());
                $user->setUpdateAt(new \DateTimeImmutable());
                $user->setStatus(true);
                $client->setUtilisateur($user);
                $manager->persist($user);

                // Création d'une dette ou plusieurs dettes
                for ($j = 0; $j < rand(0, 5); $j++) {
                    $dette = new Dette();
                    $dette->setMontantTotal(rand(1000, 100000));
                    $dette->setMontantVerser(rand(1000, 100000));
                    $dette->setClient($client);
                    $client->addDette($dette);
                    $manager->persist($dette);
                }
            } else {
                // Non soldé
                for ($j = 0; $j < rand(0, 5); $j++) {
                    $dette = new Dette();
                    $dette->setMontantTotal(rand(1000, 100000));
                    $dette->setMontantVerser(15000);
                    $dette->setClient($client);
                    $client->addDette($dette);
                    $manager->persist($dette);
                }
            }
            // Persister le client et ses dettes
            $manager->persist($client);
        }
        // Sauvegarder les clients
        $manager->flush();
    }
}
