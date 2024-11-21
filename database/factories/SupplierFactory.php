<?php

namespace Database\Factories;

use App\Services\DipomexService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
/**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $girosEmpresas = [
            'Tecnología de la Información',
            'Salud y Medicina',
            'Educación',
            'Manufactura',
            'Servicios Financieros',
            'Alimentos y Bebidas',
            'Energía y Recursos Naturales',
            'Transporte y Logística',
            'Construcción',
            'Comercio Minorista',
            'Otros'
        ];

        $suffixes = [
            'S.A.', 'S.A. de C.V.', 'S. de R.L.', 'S. de R.L. de C.V.', 'S.C.', 'S.C.P.', 
            'S.C.L.', 'S.C.S.', 'S.C.A.', 'S.N.C.', 'S.A.S.', 'S.A.P.I. de C.V.', 
            'A.C.', 'S.C. de R.L.', 'S.C.I.', 'S.R.L.'
        ];
        
        $result = null;

        // do{
        //     $postalCode = fake()->randomElement($this->postalCodes);
        //     $result = $this->fetchAddressData($postalCode);
        // }while(!$result);

        [$colonias, $estado, $municipio] = $result;

        return [
            'name' => fake()->company,
            'tax_id' => fake()->regexify('[A-Z]{3}[0-9]{9}'),
            'postal_code' => $postalCode ?? fake()->regexify('[0-9]{5}'),
            'street' => fake()->streetName(),
            'ext_number' => fake()->buildingNumber(),
            'int_number' => fake()->buildingNumber(),
            'neighborhood' => fake()->randomElement($colonias ?? [fake()->word()]),
            'town' => $municipio ?? fake()->word(),
            'state' => $estado ?? fake()->word(),
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'business_name' => fake()->randomElement($suffixes),
            'business_activity' => fake()->randomElement($girosEmpresas),
        ];
    }

    public function fetchAddressData($postalCode)
    {
        $dipomex = new DipomexService();
        $response = $dipomex->getAddressByPostalCode($postalCode);

        if (isset($response) && !$response['error']) {
            $data = $response['codigo_postal'];
            $colonias = $data['colonias'];
            $estado = $data['estado'];
            $municipio = $data['municipio'];
            
            return [$colonias, $estado, $municipio]; 
        } 
        return null;
    }


    public $postalCodes = [
        78000,
        78037,
        78038,
        78040,
        78049,
        78100,
        78106,
        78107,
        78109,
        78110,
        78116,
        78117,
        78120,
        78130,
        78133,
        78135,
        78136,
        78137,
        78140,
        78143,
        78144,
        78146,
        78147,
        78148,
        78150,
        78153,
        78154,
        78165,
        78170,
        78173,
        78174,
        78175,
        78176,
        78177,
        78178,
        78180,
        78183,
        78200,
        78209,
        78210,
        78213,
        78214,
        78215,
        78216,
        78218,
        78219,
        78220,
        78230,
        78233,
        78234,
        78235,
        78236,
        78238,
        78239,
        78240,
        78250,
        78260,
        78268,
        78269,
        78270,
        78280,
        78290,
        78294,
        78295,
        78298,
        78300,
        78307,
        78308,
        78309,
        78310,
        78318,
        78319,
        78320,
        78328,
        78330,
        78338,
        78339,
        78340,
        78342,
        78349,
        78350,
        78356,
        78358,
        78359,
        78360,
        78363,
        78364,
        78365,
        78367,
        78368,
        78369,
        78370,
        78377,
        78378,
        78379,
        78380,
        78384,
        78385,
        78387,
        78388,
        78389,
        78390,
        78394,
        78395,
        78396,
        78397,
        78398,
        78399,
        78400,
        78403,
        78404,
        78405,
        78406,
        78407,
        78410,
        78413,
        78414,
        78415,
        78416,
        78418,
        78420,
        78421,
        78423,
        78424,
        78425,
        78426,
        78427,
    ];
}
