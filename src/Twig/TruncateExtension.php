<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TruncateExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    public function truncate($text, $number)
    {
        $retval = $text;
        $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $text);
        $string = str_replace("\n", " ", $string);
        $array = explode(" ", $string);
        if (count($array)<=$number)
        {
          $retval = $string;
        }
        else
        {
          array_splice($array, $number);
          $retval = implode(" ", $array)." ...";
        }
        return $retval;
    }

    
}
