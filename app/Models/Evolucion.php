<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evolucion extends Model
{
    use HasFactory;

    protected $table = 'evolucion';
    protected $primaryKey = 'id';

    public function getUpdatedAtAttribute($value)
    {
        $date = date_create($value);
        return date_format($date,"Y-m-d H:i:s");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'numero_evolucion',
        'id_paciente',
        'url_refraccion',
        'fecha',
        'hora',
        'descripcion'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'numero_evolucion',
        'id_paciente',
        'url_refraccion',
        'fecha',
        'hora',
        'descripcion',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'numero_documento.required'  => 'El Número de Documento del paciente es requerido.',
        'url_refraccion.required'    => 'La refracción es requerida.',
        'url_refraccion.mimes'       => 'La refracción debe ser un archivo de tipo: jpg, jpeg, bmp, png.',
        'fecha.required'             => 'La Fecha es requerida.',
        'fecha.date_format'          => 'La fecha debe cumplir el formato: Y-m-d.',
        'hora.required'              => 'La Hora es requerida.',
        'hora.date_format'           => 'La Hora debe cumplir el formato: H:i.',
        'descripcion.max'            => 'La descripción de la Historia Clinica no puede superar lo 255 carácteres.'
    ];

    static $rulesStore = [
        'numero_documento'  => 'required',
        'fecha'             => 'required|date_format:Y-m-d',
        'hora'              => 'required|date_format:H:i',
        'descripcion'       => 'nullable|string|max:255'
    ];

    static function fnRulesUpdate() {
        return [
            'fecha'             => 'required|date_format:Y-m-d',
            'hora'              => 'required|date_format:H:i',
            'descripcion'       => 'nullable|string|max:255'
        ];
    }

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
                ->where('numero_evolucion', 'LIKE', "%$buscar%")
                ->orWhere('fecha', 'LIKE', "%$buscar%")
                ->orWhere('hora', 'LIKE', "%$buscar%")
                ->orWhere('updated_at', 'LIKE', "%$buscar%");
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

    /**
     * Obtiene el registro paciente asociado a evolucion. Historia clinica
     *
     * @return Illuminate\Support\Collection;
     */
    public function getPaciente(){
        return $this->belongsTo(Paciente::class,'id_paciente', 'id');
    }
}
