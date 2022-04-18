<?php

namespace App\Models\parametro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ocupacion extends Model
{
    use HasFactory;

    protected $table = 'p_ocupacion';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'codigo',
        'descripcion',
        'estado'
    ];

    /**
     * Scope para realizar una búsqueda mixta.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $buscar Valor a buscar
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscar($query, $buscar) {
        if($buscar) {
            return $query
                ->where('id', 'LIKE', "%$buscar%")
                ->orWhere('codigo', 'LIKE', "%$buscar%")
                ->orWhere('descripcion', 'LIKE', "%$buscar%")
                ->orWhere('estado', 'LIKE', "%$buscar%");
        }
    }

    /**
     * Scope para ordenar una lista.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $columna Nombnre de la columna de la tabla
     * @param mixed $orden Tipo de ordenamiento ASC|DESC
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdenamiento($query, $columna, $orden){
        if($columna && $orden){
            return $query->orderBy($columna, $orden);
        }
    }
}
