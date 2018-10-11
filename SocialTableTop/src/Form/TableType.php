<?php

namespace App\Form;

use App\Entity\Table;
use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('Mj', TextType::class, array('label' => 'MJ'))
            ->add('Description', TextType::class, array('label' => 'Description'))
            ->add('joueurs', EntityType::class, array(
                'label' => 'Joueur',
                'class' => Joueur::class,
                'choice_label' => 'name'))
            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Table::class,
        ]);
    }
}
