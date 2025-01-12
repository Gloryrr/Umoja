<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Entity\Artiste;
use App\Entity\BudgetEstimatif;
use App\Entity\GenreMusical;
use App\Entity\Commentaire;
use App\Entity\ConditionsFinancieres;
use App\Entity\EtatOffre;
use App\Entity\EtatReponse;
use App\Entity\Extras;
use App\Entity\Offre;
use App\Entity\Reponse;
use App\Entity\FicheTechniqueArtiste;
use App\Entity\PreferenceNotification;
use App\Entity\Reseau;
use App\Entity\TypeOffre;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin_umodja', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UtilisateurCrudController::class)->generateUrl());

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('UMODJA panel admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Panel admin', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-list', Utilisateur::class);
        yield MenuItem::linkToCrud('Artiste', 'fas fa-list', Artiste::class);
        yield MenuItem::linkToCrud('BudgetEstimatif', 'fas fa-list', BudgetEstimatif::class);
        yield MenuItem::linkToCrud('GenreMusical', 'fas fa-list', GenreMusical::class);
        yield MenuItem::linkToCrud('Commentaire', 'fas fa-list', Commentaire::class);
        yield MenuItem::linkToCrud('ConditionsFinancieres', 'fas fa-list', ConditionsFinancieres::class);
        yield MenuItem::linkToCrud('EtatOffre', 'fas fa-list', EtatOffre::class);
        yield MenuItem::linkToCrud('EtatReponse', 'fas fa-list', EtatReponse::class);
        yield MenuItem::linkToCrud('Extras', 'fas fa-list', Extras::class);
        yield MenuItem::linkToCrud('Offre', 'fas fa-list', Offre::class);
        yield MenuItem::linkToCrud('Reponse', 'fas fa-list', Reponse::class);
        yield MenuItem::linkToCrud('FicheTechniqueArtiste', 'fas fa-list', FicheTechniqueArtiste::class);
        yield MenuItem::linkToCrud('PreferenceNotification', 'fas fa-list', PreferenceNotification::class);
        yield MenuItem::linkToCrud('Reseau', 'fas fa-list', Reseau::class);
        yield MenuItem::linkToCrud('TypeOffre', 'fas fa-list', TypeOffre::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);

        yield MenuItem::linkToUrl('Revenir sur l\'application', 'fas fa-arrow-left', 'http://localhost:3000/profil');
    }
}
