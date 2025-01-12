<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nomUtilisateur'),
            TextField::new('prenomUtilisateur'),
            EmailField::new('emailUtilisateur'),
            TextField::new('username'),
            AssociationField::new('reseaux')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('attr', ['data-widget' => 'select2'])
                ->setFormTypeOptions([
                    'choice_label' => 'nomReseau',
                ]),
            AssociationField::new('genresMusicaux')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('attr', ['data-widget' => 'select2'])
                ->setFormTypeOptions([
                    'choice_label' => 'nomGenreMusical',
                ]),
        ];
    }
}