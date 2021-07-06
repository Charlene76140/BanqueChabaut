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
    #[Route('/', name: 'home')]
    #[Route('/index', name: 'index')]
    public function index(AccountRepository $accountRepository): Response
    {
        $accounts= $this->getUser()->getAccounts();
        
        
        // $operation = $operationRepository->findBy(
        //     [],
        //     ["id"=> "DESC"],
        //     1,
        //     0
        // );

        // dump($operations);

        return $this->render('view/index.html.twig', [
            'accounts' => $accounts,
            // 'operation' => $operation
        ]);
    }




    #[Route('/user/account/{id}', name: 'single', requirements: ['id' => '\d+'])]
    public function single(int $id=1, AccountRepository $accountRepository, Request $request): Response
    {
        $account = $accountRepository->find($id);
        $operations = $account->getOperations();

        return $this->render('view/single.html.twig', [
            "account"=>$account, 
            "operations"=> $operations,
        ]);
    }

}
