<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CompetenceController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager;
    }
    /**
     * @Route("ajout/competence", name="app_competence_ajout")
     */
    public function index(Request $request): Response
    {
        $competence = new Competence();// 
        $formcompetence= $this->createForm(CompetenceType::class,$competence);
        $formcompetence->handleRequest($request);

        if($formcompetence->isSubmitted() && $formcompetence->isValid()){
            //recuperer l'user conecter et envoyer son prenom dans le set auteur
            //ma methode c'est de la merde je suis trop une merde la meilleur methode et de cree un get pour les deux en les concatenant direct dans la function
            // $nom= $this->getUser()->getNom();
            // $prenom= $this->getUser()->getPrenom();

            $this->manager->persist($competence);
            $this->manager->flush();

            return $this->redirectToRoute('app_home');


        }
 
        return $this->render('competence/ajout.html.twig', [
            'mycompetence' => $formcompetence->createView(),
        ]);
    }
    
        /**
     * @Route("/competence", name="app_competence")
     */
    public function Vue(): Response
    {
        $afficherCompetence = $this->manager->getRepository(Competence::class)->findAll();
       
 
        return $this->render('competence/afficheCompetence.html.twig', [
            'competence' => $afficherCompetence,
        ]);
    }




        /**
     * @Route("/competence/delete/{id}", name="app_competence_delete")
     */
    public function competenceDelete(Competence $competence): Response
    {
        $this->manager->remove($competence);
        $this->manager->flush();

        return $this->redirectToRoute('app_home');
    }
    //PENSER A FAIR LE BOUTON SUPPRIMER LA COMPETENCE ET PUIS MODIFIER ETA PTRES FALLAI RECUPERER LES MSG DANS LA BASE DE DONN2E 




        /**
     * @Route("/competence/edit/{id}", name="app_competence_edit")
     */
    public function competenceEdit(Competence $competence, Request $request, SluggerInterface $slugger): Response
    {
       
       
        $formEdit= $this->createForm(CompetenceType::class,$competence);
        $formEdit->handleRequest($request);

        if($formEdit->isSubmitted() && $formEdit->isValid()){


            $this->manager->persist($competence);
            $this->manager->flush();
           return $this->redirectToRoute('app_home');
        }

        return $this->render('competence/editCompetence.html.twig', [
            'editCompetence' => $formEdit->createView(),
           
        ]);
}
}