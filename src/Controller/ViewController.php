<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Account;
use App\Entity\Operation;
use App\Entity\User;
use App\Repository\AccountRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ViewController extends AbstractController
{   
    #[Route('/', name: 'home', methods:["GET"])]
    #[Route('/index', name: 'index', methods:["GET"])]
    public function index(AccountRepository $accountRepository): Response
    {
        $accounts= $this->getUser()->getAccounts();

        dump($accounts[0]->getOperations());

        return $this->render('view/index.html.twig', [
            'accounts' => $accounts,
        ]);
    }


    #[Route('/user/account/{id}', methods:["GET", "POST"], name: 'single', requirements: ['id' => '\d+'])]
    public function single(int $id=1, AccountRepository $accountRepository, Request $request): Response
    {
        $account = $accountRepository->find($id);
        $operations = $account->getOperations();

        if($account->getUser() == $this->getUser()){
            return $this->render('view/single.html.twig', [
                "account"=>$account, 
                "operations"=> $operations,
            ]);
        } 
        else{
            return $this->redirectToRoute('index');
        }
    }

}
