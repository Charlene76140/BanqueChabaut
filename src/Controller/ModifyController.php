<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\NewAccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



// use App\Repository\AccountRepository;


class ModifyController extends AbstractController
{
    #[Route('/user/account/add', name: 'newAccount')]
    public function newAccount(Request $request): Response
    {
            $account =new Account();
        	
            $form=$this->createForm(NewAccountType::class, $account);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {
                $account->setDate( new \DateTime());
                $account->setUserId($this->getUser());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }


        return $this->render('modify/newAccount.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[ROUTE ('/user/account/delete', name: 'deleteAccount')]
    public function deleteAccount():Response
    {
        $accounts=$this->getUser()->getAccounts();
        
        return $this->render('modify/deleteAccount.html.twig', [
            "accounts" => $accounts
        ]);

    }

}
