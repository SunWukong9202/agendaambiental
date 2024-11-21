<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->userName(),
        ];
    }

    const preloaded = [
        "Televisión",
        "Computadora portátil",
        "Teléfono móvil",
        "Tableta",
        "Monitor",
        "Teclado",
        "Mouse",
        "Impresora",
        "Cargador de teléfono",
        "Altavoces",
        "Lámparas",
        "Ventiladores",
        "Aspiradora",
        "Microondas",
        "Calentador eléctrico",
        "Bicicleta",
        "Juguetes",
        "Ropa",
        "Zapatos",
        "Muebles pequeños",
    ];

    const forNamedPetitions = [
        "Auriculares",
        "Consola de videojuegos",
        "Control de videojuegos",
        "Reloj inteligente",
        "Cámara digital",
        "DVD o Blu-ray player",
        "Router Wi-Fi",
        "Disco duro externo",
        "Memoria USB",
        "Reproductor de MP3",
        "Ropa de cama",
        "Toallas",
        "Sartenes",
        "Ollas",
        "Cubiertos",
        "Vajilla",
        "Cajas de herramientas",
        "Instrumentos musicales",
        "Linternas",
        "Baterías",
        "Cargadores solares"
    ];
}
