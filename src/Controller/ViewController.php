<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Account;
use App\Entity\Operation;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\OperationRepository;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class ViewController extends AbstractController
{   
    #[Route('/', name: 'home', methods:["GET"])]
    #[Route('/index', name: 'index', methods:["GET"])]
    public function index(UserRepository $userRepository): Response
    {
        //retrieves the accounts of the logged in user
        $accounts= $this->getUser()->getAccounts();

        //used to retrieve all database users, for admin interface
        $users = $userRepository->findAll();
        
        return $this->render('view/index.html.twig', [
            'accounts' => $accounts,
            'users' => $users,
        ]);
    }

    #[Route('/user/account/{id}', methods:["GET", "POST"], name: 'single', requirements: ['id' => '\d+'])]
    public function single(int $id=1, AccountRepository $accountRepository): Response
    {
        //retrieves an account by its id retrieved from the URL
        $account = $accountRepository->find($id);
        //retrieves all transactions from the account retrieved before
        $operations = $account->getOperations();

        //protects the url and checks that the account displayed is that of the logged in user
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

    #[Route('/user/profil', methods:["GET", "POST"], name: 'userProfil')]
    public function userProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data= $form->getData();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Vos modifications ont bien été prises en compte.'
            );
            return $this->redirectToRoute('index');
        }

        return $this->render('view/userProfil.html.twig', [
            "form" => $form->createView()
        ]);
    }
}