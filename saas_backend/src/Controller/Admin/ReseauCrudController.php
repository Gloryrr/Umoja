<?php

namespace App\Controller\Admin;

use App\Entity\Reseau;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ReseauCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reseau::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nomReseau'),
            AssociationField::new('utilisateurs')
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true)
                ->setFormTypeOption('attr', ['data-widget' => 'select2'])
                ->setFormTypeOptions([
                    'choice_label' => 'username',
                ]),
        ];
    }
}
