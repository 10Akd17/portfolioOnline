<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Contact;
use App\Entity\Competence;
use App\Entity\Experience;
use App\Form\FormulaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager){

        $this->manager = $manager;
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request): Response
    {
        $afficherExperience = $this->manager->getRepository(Experience::class)->findAll();
        $afficherCompetence = $this->manager->getRepository(Competence::class)->findAll();
        $afficherProjet = $this->manager->getRepository(Projet::class)->findAll();

        $contact = new Contact(); // 
        $formContact = $this->createForm(FormulaireType::class, $contact);
        $formContact->handleRequest($request);
        
        if($formContact->isSubmitted() && $formContact->isValid()){

       

            
            $this->managerContact->persist($contact);
            $this->managerContact->flush();
           return $this->redirectToRoute('app_contact');
        }
 
        return $this->render('home/index.html.twig', [
            'experience' => $afficherExperience,
            'competence' => $afficherCompetence,
            'projet' => $afficherProjet,
            'formulaire' => $formContact->createView(),
            

        ]);
        // return $this->render('home/index.html.twig', [
        //     'controller_name' => 'HomeController',
        // ]);
    }


   



            /**
     * @Route("/", name="app_experience")
     */
    // public function Vue(): Response
    // {
    //     $afficherExperience = $this->manager->getRepository(Experience::class)->findAll();
       
 
    //     return $this->render('home/index.html.twig', [
    //         'experience' => $afficherExperience,
    //     ]);
    // }
    

    

    
}


