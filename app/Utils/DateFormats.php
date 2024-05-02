<?php

namespace App\Utils;

trait DateFormats
{
    public function fechaLegible($dateColumn)
    {
        return $this->$dateColumn->format(
            $this->$dateColumn->year === now()->year
                ? 'M d, g:i A'
                : 'M d, Y, g:i A'
        );
    }
}