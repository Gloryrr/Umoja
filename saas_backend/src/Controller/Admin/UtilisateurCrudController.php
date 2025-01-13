<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PreferenceNotification;

class UtilisateurCrudController extends AbstractCrudController {

    private MailerService $mailerService;

    public function __construct(MailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

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
            TextField::new('roleUtilisateur'),
            TextField::new('mdpUtilisateur')->onlyOnForms(),
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
    public function persistEntity(
        EntityManagerInterface $entityManager, 
        $entityInstance,
    ): void {
        if ($entityInstance instanceof Utilisateur) {
            $preferencesNotification = new PreferenceNotification();
            $entityInstance->setPreferenceNotification($preferencesNotification);
            $data = [
                'emailUtilisateur' => $entityInstance->getEmailUtilisateur(),
                'username' => $entityInstance->getUsername(),
            ];
            $this->mailerService->sendEmailNewUser($data);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}