<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitForm extends AbstractType
{
    // Création du formulaire pour le produit // Peut etre amélioré avec l'image
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_produit')
            ->add('description')
            ->add('prix')
            ->add('quantite')
            ->add('date_ajout')
            ->add('supprime')
            ->add('id_categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
