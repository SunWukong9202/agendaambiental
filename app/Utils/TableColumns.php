<?php

// app/Utils/TableColumns.php

namespace App\Utils;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

trait TableColumns
{
    private function getTableColumns($exclude, $withTimestamps = false): array
    {
        $columns = new Collection(Schema::getColumnListing($exclude['table']));
        
        if (!$withTimestamps) {
            $exclude['created_at'] = 'created_at';  
            $exclude['updated_at'] = 'updated_at';  
        }
        
        return $columns->reject(fn ($col) => in_array($col, $exclude))->all();
    }
}
