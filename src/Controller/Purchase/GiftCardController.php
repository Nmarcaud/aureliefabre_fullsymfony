<?php

namespace App\Controller\Purchase;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GiftCardController extends AbstractController
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }


    #[Route('/gift-card/{id}', name: 'gift_card_generate')]
    public function generate(int $id)
    {
        $purchase = $this->purchaseRepository->find($id);

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml($this->render('pdf/gift_card.html.twig', array(
            'purchase' => $purchase,
            'route' => $_SERVER["DOCUMENT_ROOT"]
        )));
        

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $fileName = 'Cheque_cadeau_' . $this->getUser()->getLastName();

        // Output the generated PDF to Browser
        $dompdf->stream($fileName);

        return $this->render('purchase/success_pdf.html.twig');
    }
}
