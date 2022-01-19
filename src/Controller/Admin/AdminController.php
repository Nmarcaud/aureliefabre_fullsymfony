<?php 

namespace App\Controller\Admin;

use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/dashboard', name:'admin_show_dashboard')]
    public function showDashboard(ChartBuilderInterface $chartBuilder)
    {

        // Charts Ventes Mensuelles
        // 1. Récupération des données
        $monthlyPurchases = $this->purchaseRepository->getMonthlyPurchases();

        $labels = [];
        $values = [];

        foreach ($monthlyPurchases as $month) {
            array_push($labels, $month['month(created_at)']);
            array_push($values, $month['SUM(total)']/100);
        
        }

        // 2. Génération Chart
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'CA - Ventes Mensuelles',
                    'backgroundColor' => '#5DAAD5',
                    'borderColor' => '#5DAAD5',
                    'data' => $values,
                    'tension' => 0.3
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                   'suggestedMin' => 0,
                   'suggestedMax' => max($values)/100,
                ],
            ],
        ]);


        return $this->render('admin/dashboard/index.html.twig', [
            'secondaryNavbar' => 'admin',
            'chart' => $chart
        ]);
    }
}