<?php

namespace App\Form;

use App\Entity\Objet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom de l\'objet',
        ])
        ->add('caracteristique', TextareaType::class, [
            'label' => 'Caractéristiques',
        ])
        ->add('valeurEstimee', NumberType::class, [
            'label' => 'Valeur estimée (€)',
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'required' => false, // Autorise un champ vide
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
        ]);
    }
}
