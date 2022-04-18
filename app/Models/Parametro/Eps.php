<?php

namespace App\Models\Parametro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eps extends Model
{
    use HasFactory;

    protected $table = 'p_eps';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'codigo',
        'descripcion',
        'estado',
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'codigo',
        'descripcion',
        'estado',
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
                ->orWhere('descripcion', '!=', "PARTICULAR") // Excluyendo registro
                ->orWhere('descripcion', 'LIKE', "%$buscar%")
                ->orWhere('estado', 'LIKE', "%$buscar%");
        }else{
            return $query
                ->where('descripcion', '!=', "PARTICULAR"); // Excluyendo registro
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
