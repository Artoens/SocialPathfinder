<?php

namespace App\Form;

use App\Entity\MyTable;
use App\Entity\Joueur;
use App\Entity\Personnage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PersonnageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('Joueur', EntityType::class, array(
                'label' => 'Joueur',
                'class' => Joueur::class,
                'choice_label' => 'name',
                'expanded'=>false,))
            ->add('TableDeJeux', EntityType::class, array(
                'label' => 'Table',
                'class' => MyTable::class,
                'choice_label' => 'name',
                'expanded'=>false,))
            ->add('save', SubmitType::class, array('label' => 'Sauvegarder'))
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personnage::class,
        ]);
    }
}
