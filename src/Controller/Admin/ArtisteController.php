<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    
        #[Route('/admin/artistes', name: 'admin_artist es', methods :'GET')]
        public function listeArtistes(ArtisteRepository $repo) : Response
        {
            $artistes=$paginator->paginate(
                $repo->listeArtistesComplete(),
                $request->query->getInt('page', 1), /*page number*/
                8 /*limit per page*/
            );
            return $this->render('artiste/listeArtistes.html.twig', [
                'lesArtistes' => $artistes
            ]);

          
        }
}
