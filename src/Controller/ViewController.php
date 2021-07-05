<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Account;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ViewController extends AbstractController
{   
    #[Route('/', name: 'home')]
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        // $accountRepository = $this->getDoctrine()->getRepository(Account::class);
        // $accounts = $accountRepository->findBy(
        //     ["id"=> "user_id_id"],
        // );
        $accounts= $this->getUser()->getAccounts();
        return $this->render('view/index.html.twig', [
            'accounts' => $accounts,
        ]);
        // test bla bla bla 
    }
}
