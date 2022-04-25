<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

class ClienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo_documento'    => "CC",
            'numero_documento'  => rand(1,1000),
            'nombre'            => $this->faker->name(),
            'apellido'          => $this->faker->lastName(),
            'correo'            => $this->faker->unique()->safeEmail(),
            'celular'           => rand(1,1000),
            'direccion'         => Str::random(10),
            'departamento'      => "HUILA",
            'municipio'         => "GARZON",
            'fecha_nacimiento'  => "2022-04-12",
            'edad'              => 22,
            'ocupacion'         => "ABOGADO",
            'foto'              => "",
            'id_p_eps'          => 2,
            'fecha_creacion'    => date('Y-m-d H:i:s'),
        ];
    }
}
