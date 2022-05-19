<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\FormulaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    public function __construct(EntityManagerInterface $managerContact){

        $this->managerContact = $managerContact;
    }
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contact = new Contact(); // 
        $formContact = $this->createForm(FormulaireType::class, $contact);
        $formContact->handleRequest($request);
        
        if($formContact->isSubmitted() && $formContact->isValid()){

       

            
            $this->managerContact->persist($contact);
            $this->managerContact->flush();
           return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [

            'formulaire' => $formContact->createView(),
        ]);
    }



            /**
     * @Route("/contact/messagerie", name="app_contact_messagerie")
     */
    public function Vue(): Response
    {
        $messagerie = $this->managerContact->getRepository(Contact::class)->findAll();
       
 
        return $this->render('contact/messagerie.html.twig', [
            'messagerie' => $messagerie,
        ]);
    }




    
    /**
     * @Route("/contact/delete/{id}", name="app_messagerie_delete")
     */
    public function articleDelete(Contact $contact): Response
    {
        $this->managerContact->remove($contact);
        $this->managerContact->flush();

        return $this->redirectToRoute('app_home');
    }


}
