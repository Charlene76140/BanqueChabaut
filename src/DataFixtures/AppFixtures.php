<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Entity\Account;
use App\Entity\Operation;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for($i=1; $i < 3; $i++){
            $user = new User();
            $user->setEmail("mail" . $i . "@gmail.com");
            $password = $this->encoder->encodePassword($user, "password" . $i);
            $user->setPassword($password);
            $user->setFirstname("Firstname " . $i);
            $user->setLastname("Lastname " . $i);
            $user->setCity("Rouen");
            $user->setPostal("76000");
            $user->setRoles([]);

            for($j=1; $j < 3; $j++){
                $account = new Account();
                $account->setNumber("FR76 1234 " . $j);
                $account->setDate(new \DateTime());
                $account->setAmount(mt_rand(100, 500));
                $account->setUser($user);

                $type = mt_rand(1,3);
                if($type == 1){
                    $account->setType("Compte courant");
                }
                elseif($type == 2){
                    $account->setType("Livret A");
                }
                else {
                    $account->setType("PEL");
                }
                $manager->persist($account);

                for($k=1; $k < 30 ; $k++){
                    $operation = new Operation();
                    $operation->setDate(new \DateTime());
                    $operation->setLabel("Nouvelle operation n° " .$k);
                    $operation->setAccount($account);

                    $amount = mt_rand(-500, 500);
                    $operation->setAmount($amount);
                    if($amount < 0){
                        $operation->setType("Debit");
                    }
                    else{
                        $operation->setType("Credit");
                    }
                    $manager->persist($operation);
                }
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}
