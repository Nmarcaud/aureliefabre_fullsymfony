<?php 

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class TwigExtensions extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('amount', [$this, 'amount']),
            new TwigFilter('duration', [$this, 'duration']),
        ];
    }

    // Filtre d'affichage du prix
    public function amount($value)
    {
        $amount = $value / 100;
        return $amount . "€";
    }

    // Filtre d'affichage de la durée
    public function duration($value)
    {   
        if ($value > 60) {
            $min = $value % 60;
            $hour = ( $value - $min ) / 60;
            return $hour . 'h' . $min . 'min';
        } else {
            return $value . 'min';
        }
    }
}