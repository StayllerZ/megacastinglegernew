<?php

namespace App\Controller;

use App\Entity\Offre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;
use App\Entity\User;
use function Deployer\get;

class AccueilController extends AbstractController
{
    #[Route('/Accueil', name: 'app_test')]
    public function GetOffres(EntityManagerInterface $entityManager): Response
    {
        $offres = $entityManager->getRepository(Offre::class)->findAll();

        return $this->render('Accueil//index.html.twig', [
            'offres' => $offres,
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(Request $request, EntityManagerInterface $entityManager): Response
    {
        $id = $request->query->get('id');
        $offres = $entityManager->getRepository(Offre::class)->findSearch2($id);

        return $this->render('Accueil//index.html.twig', [
            'offres' => $offres,
        ]);
    }



    #[Route('/subscribe/{id}', name: 'app_subscribe')]
    public function addUser(EntityManagerInterface $entityManager, int $id): Response
    {
        $offre = $entityManager->getRepository(Offre::class)->find($id);
        $user = $this->getUser();
        if($user != null){
            $offre->addOffreUser($user);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_test');
        }
        else{
            return $this->redirectToRoute('app_login');
        }


    }

    #[Route('/unsubscribe/{id}', name: 'app_subscribe')]
    public function removeUser(EntityManagerInterface $entityManager, int $id): Response
    {
        $offre = $entityManager->getRepository(Offre::class)->find($id);
        $user = $this->getUser();
        if($user != null){
            $offre->removeOffreUser($user);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_profil');
        }
        else{
            return $this->redirectToRoute('app_login');
        }


    }


    #[Route('/profil', name: 'app_profil')]
    public function getProfil(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $results = $entityManager->getRepository(User::class)->find($user->getId());

        return $this->render('profil/index.html.twig', [
            'profil' => $user,
            'results' => $results,
        ]);
    }
}
