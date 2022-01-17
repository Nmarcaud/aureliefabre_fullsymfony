<?php

namespace App\Controller\Purchase;


// use Knp\Snappy\Pdf;
use Knp\Snappy\Pdf;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    protected $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }


    #[Route('/invoice/{id}', name: 'invoice_generate')]
    public function generate(int $id, Pdf $knpSnappyPdf): PdfResponse
    {

        $purchase = $this->purchaseRepository->find($id);


        // Imgae file ?

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml(
                $this->renderView(
                    'pdf/gift_card.html.twig',
                    array(
                        'purchase'  => $purchase
                    )
                )
            ),
            'file.pdf'
        );


    }

}
