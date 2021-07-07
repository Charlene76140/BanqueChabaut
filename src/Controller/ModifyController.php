<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\NewAccountType;
use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AccountRepository;



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
                $account->setUser($this->getUser());
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }


        return $this->render('modify/newAccount.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/user/account/delete/{id}', name: 'deleteAccount', requirements: ['id' => '\d+'])]
    public function deleteAccount(int $id=0, AccountRepository $accountRepository, Request $request): Response
    {
       
        $accounts = $this->getUser()->getAccounts();
        $account= $accountRepository->find($id);

        if($account){
            if($this->isCsrfTokenValid('delete' . $account->getId(),$request->get('_token'))){
                $this->getUser()->removeAccount($account);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);
                $entityManager->flush();

                return $this->redirectToRoute('index');
            }
        }

        return $this->render('modify/deleteAccount.html.twig', [
            "accounts"=>$accounts, 
        ]);
    }




    #[Route('/user/account/transaction', name: 'transaction')]
    public function transaction(Request $request): Response
    {
        $accounts = $this->getUser()->getAccounts();

            $form=$this->createForm(TransactionType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()) {

                
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist();
                // $entityManager->flush();

                return $this->redirectToRoute('index');
            }


        return $this->render('modify/transaction.html.twig', [
            "form" => $form->createView(),
            "accounts" => $accounts
        ]);
    }

}
