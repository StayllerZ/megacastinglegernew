<?php

namespace App\Controller;

use App\Entity\Offre;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreController extends AbstractController
{
    #[Route('/offre/{id}', name: 'app_offre')]
    public function getOffre(EntityManagerInterface $entityManager, int $id): Response
    {
        // Utilisez l'ID pour récupérer l'offre depuis la base de données
        $offre = $entityManager->getRepository(Offre::class)->find($id);

        // Vérifiez si l'offre existe
        if (!$offre) {
            throw $this->createNotFoundException('Offre non trouvée pour l\'ID '.$id);
        }

        $dateCreation = $offre->getDateDebutCasting();
        $results = $dateCreation->format('Y-m-d');


        // Passez l'offre à la vue et affichez-la
        return $this->render('offre/index.html.twig', [
            'offre' => $offre,
            'dateCasting' => $results,
        ]);
    }

}
