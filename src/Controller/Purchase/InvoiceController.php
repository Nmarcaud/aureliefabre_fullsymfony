<?php

namespace App\Controller\Purchase;


// use Knp\Snappy\Pdf;
use Knp\Snappy\Pdf;
use App\Repository\PurchaseRepository;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

class InvoiceController extends AbstractController
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


    #[Route('/invoice/{id}', name: 'invoice_generate')]
    public function generate(int $id): PdfResponse
    {
        // Reset néecessaire pour récupérer le style avec Encore ?!
        $this->entrypointLookup->reset();

        $purchase = $this->purchaseRepository->find($id);

        $name = 'Facture_' . $purchase->getId() . '.pdf';
        
        return new PdfResponse(
            $this->pdf->getOutputFromHtml(
                $this->renderView(
                    'pdf/invoice.html.twig',
                    array(
                        'purchase'  => $purchase
                    )
                )
            ),
            $name
        );


    }

}
