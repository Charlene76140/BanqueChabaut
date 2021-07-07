<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Operation;
use App\Repository\AccountRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;




class TransactionType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {  

        
        // $id = $user->getId();
        
        $builder


            ->add ('account', EntityType::class,[
                'class'=>Account::class,
                'query_builder'=> function (EntityRepository $account){
                    $user = $this->security->getUser();
                    return $account->createQueryBuilder('a')
                        ->innerJoin('a.user','u')
                        ->addSelect('u')
                        ->where('u.id = :id')
                        ->setParameter('id', $user->getId());
                        
                
                },
                'choice_label' => 'number' 
                
            ])

            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Débit' => 'Débit',
                    'Retrait' => 'Retrait',
                ],
                
            ])
            ->add('amount', NumberType::class, [
                "label" => "Montant",
                
            ])
            ->add('enregistrer', SubmitType::class, [
                "attr" => ['class' => 'btn bgColorSec text-white my-3'],
                'row_attr' => ['class' => 'text-center']
            ]);
     
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
