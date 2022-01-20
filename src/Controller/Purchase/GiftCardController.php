<?php

namespace App\Controller\Purchase;

use Knp\Snappy\Pdf;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GiftCardController extends AbstractController
{
    
    protected $purchaseRepository;
    protected $pdf;
    protected $entrypointLookup;

    public function __construct(PurchaseRepository $purchaseRepository, Pdf $pdf, EntrypointLookupInterface $entrypointLookup)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->pdf = $pdf;
        $this->entrypointLookup = $entrypointLookup;
    }


    #[Route('/gift-card/{id}', name: 'gift_card_generate')]
    public function generate(int $id): PdfResponse
    {
        // Reset néecessaire pour récupérer le style avec Encore ?!
        $this->entrypointLookup->reset();

        $purchase = $this->purchaseRepository->find($id);



        $name = 'Cheque_Cadeau_' . $purchase->getId() . '.pdf';
        
        return new PdfResponse(
            $this->pdf->getOutputFromHtml(
                $this->renderView(
                    'pdf/gift_card.html.twig',
                    array(
                        'purchase'  => $purchase
                    )
                )
            ),
            $name
        );

    }
}




// protected $purchaseRepository;

    // public function __construct(PurchaseRepository $purchaseRepository)
    // {
    //     $this->purchaseRepository = $purchaseRepository;
    // }


    // #[Route('/gift-card/{id}', name: 'gift_card_generate')]
    // public function generate(int $id, Html2pdfFactory $html2pdfFactory)
    // {
    //     $purchase = $this->purchaseRepository->find($id);

        
    //     // $pdf = $html2pdfFactory->create();
    //     // $pdf->writeHTML('<h1>Test</h1>');
    //     // $pdf->output($name = 'Coucou.pdf');
	
      

    //     $dompdf = new Dompdf(array('enable_remote' => true));
    //     $dompdf->loadHtml($this->render('pdf/gift_card.html.twig', array(
    //         'purchase' => $purchase,
    //         'route' => $_SERVER["DOCUMENT_ROOT"]
    //     )));
        

    //     // (Optional) Setup the paper size and orientation
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Render the HTML as PDF
    //     $dompdf->render();

    //     $fileName = 'Cheque_cadeau_' . $this->getUser()->getLastName();

    //     // Output the generated PDF to Browser
    //     $dompdf->stream($fileName);

    //     return $this->render('purchase/success_pdf.html.twig');
    // }