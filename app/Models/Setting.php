<?php

namespace App\Models;

use App\Enums\Setting as EnumsSetting;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'key' => EnumsSetting::class,
    ];

    public static function getValue($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->castValue($value, $this->type),
            set: fn($value) => $this->prepareValue($value, $this->type)
        );
    }

    protected function castValue($value, $type)
    {
        switch ($type) {
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'decimal':
                return $this->castDecimal($value); 
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'json':
                return json_decode($value, true);
            default:
                return (string) $value;
        }
    }

    protected function prepareValue($value, $type)
    {
        switch ($type) {
            case 'integer':
            case 'float':
            case 'boolean':
                return $value;
            case 'decimal':
                return $this->prepareDecimal($value);  
            case 'json':
                return json_encode($value);
            default:
                return (string) $value;
        }
    }   
    
    protected function castDecimal($value)
    {
        return bcmul($value, 3, '.', '');  
    }

    protected function prepareDecimal($value)
    {
        return bcmul($value, 3, '.', '');  
    }
}