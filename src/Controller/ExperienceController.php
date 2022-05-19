<?php

namespace App\Controller;

use App\Entity\Experience;
use App\Form\ExperienceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExperienceController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager;
    }
    /**
     * @Route("ajout/experience", name="app_experience_ajout")
     */
    public function index(Request $request): Response
    {
        $experience = new Experience();// 
        $formExperience= $this->createForm( ExperienceType::class,$experience);
        $formExperience->handleRequest($request);

        if($formExperience->isSubmitted() && $formExperience->isValid()){
            //recuperer l'user conecter et envoyer son prenom dans le set auteur
            //ma methode c'est de la merde je suis trop une merde la meilleur methode et de cree un get pour les deux en les concatenant direct dans la function
            // $nom= $this->getUser()->getNom();
            // $prenom= $this->getUser()->getPrenom();

            $this->manager->persist($experience);
            $this->manager->flush();

            return $this->redirectToRoute('app_home');


        }
 
        return $this->render('experience/ajoutExperience.html.twig', [
            'myExperience' => $formExperience->createView(),
        ]);
    }
    
        /**
     * @Route("/experience", name="app_experience")
     */
    public function Vue(): Response
    {
        $afficherExperience = $this->manager->getRepository(Experience::class)->findAll();
       
 
        return $this->render('experience/afficheExperience.html.twig', [
            'experience' => $afficherExperience,
        ]);
    }




        /**
     * @Route("/experience/delete/{id}", name="app_experience_delete")
     */
    public function experienceDelete(Experience $experience): Response
    {
        $this->manager->remove($experience);
        $this->manager->flush();

        return $this->redirectToRoute('app_home');
    }
    //PENSER A FAIR LE BOUTON SUPPRIMER LA COMPETENCE ET PUIS MODIFIER ETA PTRES FALLAI RECUPERER LES MSG DANS LA BASE DE DONN2E 




        /**
     * @Route("/experience/edit/{id}", name="app_experience_edit")
     */
    public function experienceEdit(Experience $experience, Request $request, SluggerInterface $slugger): Response
    {
       
       
        $formEdit= $this->createForm(ExperienceType::class,$experience);
        $formEdit->handleRequest($request);

        if($formEdit->isSubmitted() && $formEdit->isValid()){


            $this->manager->persist($experience);
            $this->manager->flush();
           return $this->redirectToRoute('app_home');
        }

        return $this->render('experience/editExperience.html.twig', [
            'editExperience' => $formEdit->createView(),
           
        ]);
}
}
