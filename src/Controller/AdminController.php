<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\AccountRepository;
use App\Repository\UserRepository;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    #[Route('admin/account/{id}', methods:["GET", "POST"], name: 'adminAccount', requirements: ['id' => '\d+'])]
    public function adminAccounts(int $id=1, UserRepository $userRepository): Response
    {
        $user= $userRepository->find($id);
        $accounts = $user->getAccounts();

        return $this->render('admin/account.html.twig', [
            'accounts' => $accounts,
        ]);
    }
}
