<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Operation;
use App\Entity\Transaction;
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

//===========================================================================
//=============================== Virement ==================================
//===========================================================================


    #[Route('/user/account/transaction', name: 'transaction')]
    public function transaction(Request $request): Response
    {   
        $operationDebit= new Operation;
        $operationCredit= new Operation;
        
        $form=$this->createForm(TransactionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $debitAccount=$form->getData()->getDebitAccount();
            $creditAccount=$form->getData()->getCreditAccount();
            $amount=$form->getData()->getAmount();
            $debitAccountAmount=$debitAccount->getAmount();
            $creditAccountAmount=$creditAccount->getAmount();

            $operationDebit->setAmount(-$amount);
            $operationDebit->setDate( new \DateTime);
            $operationDebit->setType("Debit");
            $operationDebit->setLabel("Virement vers le compte ". $creditAccount->getType(). " " . $creditAccount->getNumber());
            $operationDebit->setAccount($debitAccount);

            $operationCredit->setAmount($amount);
            $operationCredit->setDate( new \DateTime);
            $operationCredit->setType("Credit");
            $operationCredit->setLabel("Virement depuis le compte ". $debitAccount->getType(). " " . $debitAccount->getNumber());
            $operationCredit->setAccount($creditAccount);

            $debitAccount->setAmount($debitAccountAmount - $amount);
            $creditAccount->setAmount($creditAccountAmount + $amount);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($debitAccount);
            $entityManager->persist($creditAccount);
            $entityManager->persist($operationDebit);
            $entityManager->persist($operationCredit);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Vos modifications ont bien été prises en compte.'
            );
            return $this->redirectToRoute('index');
        }
        return $this->render('modify/transaction.html.twig', [
            "form" => $form->createView(),
        ]);       
    }


    //===============================================================================
    //========================= Fonction Debit/Credit ===============================
    //===============================================================================

    // #[Route('/user/account/transaction', name: 'transaction')]
    // public function transaction(Request $request): Response
    // {
    //     $accounts = $this->getUser()->getAccounts();

    //         $operation = new Operation();

    //         $form=$this->createForm(TransactionType::class);
    //         $form->handleRequest($request);
    //         if($form->isSubmitted() && $form->isValid()) {
    //             $formPost=$form->getData();
    //             // dump($form->getData()->getType());
    //             $operation->setDate( new \DateTime());
    //             $operation->setLabel("Nouvelle opération");
    //             $operation->setType($formPost->getType());
    //             $operation->setAmount($formPost->getAmount());
    //             $operation->setAccount($formPost->getAccount());
    //             $entityManager = $this->getDoctrine()->getManager();
    //             $entityManager->persist($operation);


    //             $account=$formPost->getAccount();
    //             $amount=$account->getAmount();

    //             $type=$formPost->getType();
    //             if($type=="Debit"){
    //                 $newAmount= $amount - $formPost->getAmount();
    //                 $account->setAmount($newAmount);
    //                 $entityManager->persist($account);
                                    
    //             }
    //             if($type=="Credit"){
    //                 $newAmount= $amount + $formPost->getAmount();
    //                 $account->setAmount($newAmount);
    //                 $entityManager->persist($account);
    //             }
                
                
    //             $entityManager->flush();

    //             return $this->redirectToRoute('index');
    //         }


    //     return $this->render('modify/transaction.html.twig', [
    //         "form" => $form->createView(),
    //         "accounts" => $accounts
    //     ]);
    // }

}
