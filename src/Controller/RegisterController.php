<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegisterController extends AbstractController
{
    public function __construct(EntityManagerInterface $manager,UserPasswordHasherInterface $passwordHasher){

        $this->manager = $manager;
        $this->passwordHasher = $passwordHasher;

    }
    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request): Response{

        $admin = new Admin();// nouvelle instance de admin
   
        $form= $this->createForm(RegisterType::class,$admin);//Creation du formulaire
        $form->handleRequest($request);//traitement du formulaire
      

        if($form->isSubmitted() && $form->isValid()){// si le formulaire est soumis et valide alors
            $emptypassword = $form->get('password')->getdata();
           
            if($emptypassword == null){

                $admin->setPassword($admin->getPassword());

            }else{

                $encode = $this->passwordHasher->hashPassword($admin, $emptypassword);
                $admin->setPassword($encode);
            }

            
            $this->manager->persist($admin);
            $this->manager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'myform' => $form->createView(),
        ]);
    }
}

