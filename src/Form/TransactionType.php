<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;




class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
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
            'data_class' => Account::class,
        ]);
    }
}
