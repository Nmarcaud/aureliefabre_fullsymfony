<?php
// Exemple de DataTransformer - non utilisé -

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class CentimesTransformer implements DataTransformerInterface 
{
    public function transform($value)
    {
        // Si pas de value - stop
        if ($value === null) {
            return;
        }
        return $value / 100;
    }

    public function reverseTransform($value)
    {
        // Si pas de value - stop
        if ($value === null) {
            return;
        }
        return $value * 100;
    }
}