<?php

namespace App\Models\Parametro;

use DateTimeInterface;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Eps extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $table = 'p_eps';
    protected $primaryKey = 'id';

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return ["EPS"];
    }

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
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
        'created_at',
        'updated_at'
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
                ->where('descripcion', '!=', "PARTICULAR") // Excluyendo registro
                // ->where('id', 'LIKE', "%$buscar%")
                ->where('codigo', 'LIKE', "%$buscar%")
                ->orWhere('descripcion', 'LIKE', "%$buscar%")
                ->orWhere('estado', 'LIKE', "%$buscar%")
                ->orWhere('created_at', 'LIKE', "%$buscar%")
                ->orWhere('updated_at', 'LIKE', "%$buscar%");
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
