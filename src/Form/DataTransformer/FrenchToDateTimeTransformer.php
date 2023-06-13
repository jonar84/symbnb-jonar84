<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface {

    public function transform($date)
    {
        if ($date === null)
        {
            return '';
        }
        return $date->format('d/m/Y');    
    }

    public function reverseTransform($frenchDate)
    {
        // French Date => 21/09/2023
        
        if ($frenchDate === null) 
        {
            // Exception
            throw new TransformationFailedException("Vous devez fournir une date");
        }

        $date = \Datetime::createFromFormat('d/m/Y', $frenchDate);

        if ($date === false) 
        {
            // Exception
            throw new TransformationFailedException("Mauvais format de date");
        }

        return $date;
    }
}