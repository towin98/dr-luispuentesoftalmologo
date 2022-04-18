<?php

namespace Database\Seeders;

use App\Models\Parametro\Eps;
use Illuminate\Database\Seeder;

class epsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $eps = [
            [
                'codigo'      => '0001',
                "descripcion" => "PARTICULAR",
                "estado"      => "ACTIVO"
            ],
            [
                'codigo'      => '0002',
                "descripcion" => "SURA",
                "estado"      => "ACTIVO"
            ],
            [
                'codigo'     => '0003',
                "descripcion" => "COLSANITAS",
                "estado"      => "ACTIVO"
            ],
            [
                'codigo'     => '0004',
                "descripcion" => "COOMEVA",
                "estado"      => "ACTIVO"
            ],
            [
                'codigo'      => '0005',
                "descripcion" => "MEDPLUS",
                "estado"      => "ACTIVO"
            ],
            [
                'codigo'      => '0006',
                "descripcion" => "COLMEDICA",
                "estado"      => "ACTIVO"
            ],
        ];
        foreach ($eps as $valueEps) {
            Eps::create([
                'codigo'       => $valueEps['codigo'],
                'descripcion'  => $valueEps['descripcion'],
                'estado'       => $valueEps['estado']
            ]);
        }
    }
}
