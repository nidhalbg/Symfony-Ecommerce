<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', SearchType::class, array(
                    'constraints' => new Length(array('min' => 3)
                    ),
                    'attr' => array('placeholder' => 'Rechercher un produit') 
            ))
            ->add('send', SubmitType::class, array('label' => 'Envoyer'))
            ->add('order', ChoiceType::class, array(
                'choices' => array(
                    'Trier par prix' => '',
                    'Croissant ' => 'ASC',
                    'Décroissant' => 'DESC',
                ),
                'label' => 'Trier par prix'
            ))
        ;
    }

}