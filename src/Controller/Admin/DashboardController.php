<?php

namespace App\Controller\Admin;

use App\Entity\Catalog;
use App\Entity\ClientContact;
use App\Entity\Ingridient;
use App\Entity\Order;
use App\Entity\RentBeds;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CatalogCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Online garden');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'homepage');
        yield MenuItem::linkToCrud('Catalog', 'fas fa-list', Catalog::class);
        yield MenuItem::linkToCrud('RentBeds', 'fas fa-list', RentBeds::class);
        yield MenuItem::linkToCrud('Order', 'fas fa-list', Order::class);
        yield MenuItem::linkToCrud('ClientContact', 'fas fa-list', ClientContact::class);
        if( $this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToCrud('Users', 'fas fa-list', User::class);

        }
    }


}
