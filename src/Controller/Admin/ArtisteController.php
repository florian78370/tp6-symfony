<?php

namespace App\Controller\Admin;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtisteController extends AbstractController
{
    
        #[Route('/admin/artistes', name: 'admin_artistes', methods :'GET')]
        public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request) : Response
        {
            $artistes=$paginator->paginate(
                $repo->listeArtistesCompletePaginee(),
                $request->query->getInt('page', 1), /*page number*/
                8 /*limit per page*/
            );
            return $this->render('admin/artiste/listeArtistes.html.twig', [
                'lesArtistes' => $artistes
            ]);
        }

        #[Route('/admin/artiste/ajout', name: 'admin_artiste_ajout', methods : ["GET", "POST"])]
        
        public function AjouterArtiste( Request $request, EntityManagerInterface $manager) : Response
        {
            $artiste=new Artiste();
            $form=$this->createForm(ArtisteType::class, $artiste);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) { 
                $manager->persist($artiste);
                $manager->flush();
                $this->addFlash("success","L'artiste a bien été ajouté");
                return $this->redirectToRoute('admin_artistes');
            }
            return $this->render('admin/artiste/formAjoutArtiste.html.twig', [
                'formArtiste' => $form->createView()
            ]);
        }

        #[Route('/admin/artiste/modif/{id}', name: 'admin_artiste_modif', methods : ["GET", "POST"])]
        
        public function modifArtiste(Artiste $artiste, Request $request, EntityManagerInterface $manager) : Response
        {
            $form=$this->createForm(ArtisteType::class, $artiste);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            { 
                $manager->persist($artiste);
                $manager->flush();
                $this->addFlash("success","L'artiste a bien été modifié");
                return $this->redirectToRoute('admin_artistes');
            }
            return $this->render('admin/artiste/formModifArtiste.html.twig', [
                'formArtiste' => $form->createView()
            ]);
        }
}
