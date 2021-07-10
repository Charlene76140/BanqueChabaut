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

    //==============================================================================
    //=============================== Account Management ===========================
    //==============================================================================


    #[Route('/user/account/add', name: 'newAccount')]
    public function newAccount(Request $request): Response
    {
            $account =new Account();
            $operation= new Operation();
  
            $form=$this->createForm(NewAccountType::class, $account);
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()) {
                
                //Type in Dropdown
                $selectType=$form->getData()->getType();
                //Generate random account Number
                $accountNum=[];
                for($i=0;$i<3;$i++){
                    $chaine=rand(0000,9999);
                   array_push($accountNum, $chaine);
                }
                $number=implode(" ",$accountNum);
                //Set new Account
                if($selectType==="Compte Courant"){
                    $account->setNumber("FR76 " . $number . " CC");
                }
                elseif($selectType=== "PEL"){
                    $account->setNumber("FR76 " . $number . " PEL");
                }
                elseif($selectType=== "Livret A" ){
                    $account->setNumber("FR76 " . $number . " LA");
                }
                $account->setDate( new \DateTime());
                $account->setUser($this->getUser());
                //Set new Operation
                $operation->setDate( new \DateTime());
                $operation->setLabel("Ouverture du compte");
                $operation->setType("Crédit");
                $operation->setAccount($account);
                $operation->setAmount($form->getData()->getAmount());
                //Writting in DB
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);
                $entityManager->persist($operation);
                $entityManager->flush();

                //Flash mesage in index
                $this->addFlash(
                    'success',
                    'Vos modifications ont bien été prises en compte.'
                );
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

                //Flash mesage in index
                $this->addFlash(
                'success',
                'Vos modifications ont bien été prises en compte.'
                );
                return $this->redirectToRoute('index');
            }
        }
        return $this->render('modify/deleteAccount.html.twig', [
            "accounts"=>$accounts, 
        ]);
    }

//===========================================================================
//=============================== Transfert =================================
//===========================================================================


    #[Route('/user/account/transaction', name: 'transaction')]
    public function transaction(Request $request): Response
    {   
        $operationDebit= new Operation;
        $operationCredit= new Operation;
        
        $form=$this->createForm(TransactionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            //Update accounts to debit and credit
            $debitAccount=$form->getData()->getDebitAccount();
            $creditAccount=$form->getData()->getCreditAccount();
            $amount=$form->getData()->getAmount();
            $debitAccountAmount=$debitAccount->getAmount();
            $creditAccountAmount=$creditAccount->getAmount();
            
            //Create new operation for debit
            $operationDebit->setAmount(-$amount);
            $operationDebit->setDate( new \DateTime);
            $operationDebit->setType("Debit");
            $operationDebit->setLabel("Virement vers le compte ". $creditAccount->getType(). " " . $creditAccount->getNumber());
            $operationDebit->setAccount($debitAccount);

            //Create opreation for credit
            $operationCredit->setAmount($amount);
            $operationCredit->setDate( new \DateTime);
            $operationCredit->setType("Credit");
            $operationCredit->setLabel("Virement depuis le compte ". $debitAccount->getType(). " " . $debitAccount->getNumber());
            $operationCredit->setAccount($creditAccount);

            //Calcutation
            $debitAccount->setAmount($debitAccountAmount - $amount);
            $creditAccount->setAmount($creditAccountAmount + $amount);
            
            // Writting DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($debitAccount);
            $entityManager->persist($creditAccount);
            $entityManager->persist($operationDebit);
            $entityManager->persist($operationCredit);
            $entityManager->flush();

            //Flash message in index
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
