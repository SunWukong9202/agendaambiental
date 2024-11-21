<?php

namespace App\Utils;

use Carbon\Carbon;

trait DateFormats
{
    public function dateTime($dateColumn)
    {   //default timezone
        $date = Carbon::parse($this->$dateColumn)->timezone('America/Mexico_City');
    
        return $date->format(
            $date->year === now()->year
                ? 'M d, g:i A'
                : 'M d, Y, g:i A'
        );
    }
}