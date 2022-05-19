<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjetController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager;
    }
    /**
     * @Route("ajout/projet", name="app_projet_ajout")
     */
    public function index(Request $request): Response
    {
        $projet = new Projet();// 
        $formProjet= $this->createForm(ProjetType::class,$projet);
        $formProjet->handleRequest($request);

        if($formProjet->isSubmitted() && $formProjet->isValid()){
            //recuperer l'user conecter et envoyer son prenom dans le set auteur
            //ma methode c'est de la merde je suis trop une merde la meilleur methode et de cree un get pour les deux en les concatenant direct dans la function
            // $nom= $this->getUser()->getNom();
            // $prenom= $this->getUser()->getPrenom();

            $this->manager->persist($projet);
            $this->manager->flush();

            return $this->redirectToRoute('app_home');


        }
 
        return $this->render('projet/ajoutProjet.html.twig', [
            'myprojet' => $formProjet->createView(),
        ]);
    }
    
        /**
     * @Route("/projet", name="app_projet")
     */
    public function Vue(): Response
    {
        $afficherProjet = $this->manager->getRepository(Projet::class)->findAll();
       
 
        return $this->render('projet/afficheProjet.html.twig', [
            'projet' => $afficherProjet,
        ]);
    }




        /**
     * @Route("/projet/delete/{id}", name="app_projet_delete")
     */
    public function projetDelete(Projet $projet): Response
    {
        $this->manager->remove($projet);
        $this->manager->flush();

        return $this->redirectToRoute('app_home');
    }
    //PENSER A FAIR LE BOUTON SUPPRIMER LA COMPETENCE ET PUIS MODIFIER ETA PTRES FALLAI RECUPERER LES MSG DANS LA BASE DE DONN2E 




        /**
     * @Route("/projet/edit/{id}", name="app_projet_edit")
     */
    public function projeteEdit(Projet $projet, Request $request, SluggerInterface $slugger): Response
    {
       
       
        $formEdit= $this->createForm(ProjetType::class,$projet);
        $formEdit->handleRequest($request);

        if($formEdit->isSubmitted() && $formEdit->isValid()){


            $this->manager->persist($projet);
            $this->manager->flush();
           return $this->redirectToRoute('app_home');
        }

        return $this->render('projet/editProjet.html.twig', [
            'editProjet' => $formEdit->createView(),
           
        ]);
}
}
