<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 17/1/2018
 * Time: 11:00
 */

namespace AppBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class UpperCaseTransform implements DataTransformerInterface
{

    public function transform($text)
    {

        var_dump(get_class($text));die;

        return strtoupper($text);
    }

    public function reverseTransform($text)
    {
        return $text;
    }
}