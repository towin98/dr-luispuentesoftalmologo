<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Evolucion extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return ["EVOLUCION"];
    }

    protected $table = 'evolucion_hc';
    protected $primaryKey = 'evo_id';

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
        'evo_id_paciente',
        'evo_id_historia_clinica',
        'evo_consecutivo',
        'evo_fecha_diligenciamiento',
        'evo_descripcion_evolucion',
        'evo_tratamiento',
        'evo_orden_medica',
        'evo_rx_od',
        'evo_rx_oi',
        'evo_adicion',
        'evo_dp',
        'evo_observacion'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'evo_id',
        'evo_id_paciente',
        'evo_id_historia_clinica',
        'evo_consecutivo',
        'evo_fecha_diligenciamiento',
        'evo_descripcion_evolucion',
        'evo_tratamiento',
        'evo_orden_medica',
        'evo_rx_od',
        'evo_rx_oi',
        'evo_adicion',
        'evo_dp',
        'evo_observacion',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'numero_documento.required'                     => 'El Número de Documento del paciente es requerido.',
        'evo_id_historia_clinica.required'              => 'El id de la historia clinica es requerido.',
        'evo_fecha_diligenciamiento.required'           => 'La fecha de diligenciamiento de la evolución es requerida.',
        'evo_fecha_diligenciamiento.date_format'        => 'La fecha de diligenciamiento de la evolución es debe ser ej: Y-m-d.',
        'evo_descripcion_evolucion.required'            => 'La Descripción de la Evolución es requerida.',
        'evo_rx_od.required'                            => 'El RX Ojo Derecho es requerido.',
        'evo_rx_od.string'                              => 'El RX Ojo Derecho debe ser un string.',
        'evo_rx_od.max'                                 => 'El RX Ojo Derecho es máximo 30 carácteres.',
        'evo_rx_oi.required'                            => 'El RX Ojo Izquierdo es requerido.',
        'evo_rx_oi.string'                              => 'El RX Ojo Izquierdo debe ser un string.',
        'evo_rx_oi.max'                                 => 'El RX Ojo Izquierdo es máximo 30 carácteres.',
        'evo_adicion.required'                          => 'La adicion es requerida.',
        'evo_adicion.string'                            => 'La adicion debe ser un string.',
        'evo_adicion.max'                               => 'La adicion es máximo 30 carácteres.',
        'evo_dp.required'                               => 'La Distancia Pupilar es requerida.',
        'evo_dp.string'                                 => 'La Distancia Pupilar debe ser un string.',
        'evo_dp.max'                                    => 'La Distancia Pupilar es máximo 30 carácteres.',
        'evo_observacion.required'                      => 'La Observacion es requerida.',
        'evo_observacion.string'                        => 'La Observacion debe ser un string.'
    ];

    static $rulesStore = [
        'numero_documento'           => 'required',
        'evo_id_historia_clinica'    => 'required',
        'evo_fecha_diligenciamiento' => 'required|date_format:Y-m-d',
        'evo_descripcion_evolucion'  => 'required|string',
        'evo_tratamiento'            => 'nullable|string',
        'evo_orden_medica'           => 'nullable|string',
        'evo_rx_od'                  => 'nullable|string|max:30',
        'evo_rx_oi'                  => 'nullable|string|max:30',
        'evo_adicion'                => 'nullable|string|max:30',
        'evo_dp'                     => 'nullable|string|max:30',
        'evo_observacion'            => 'nullable|string',
    ];

    static $rulesUpdate = [
        'evo_fecha_diligenciamiento' => 'required|date_format:Y-m-d',
        'evo_descripcion_evolucion'  => 'required|string',
        'evo_tratamiento'            => 'nullable|string',
        'evo_orden_medica'           => 'nullable|string',
        'evo_rx_od'                  => 'nullable|string|max:30',
        'evo_rx_oi'                  => 'nullable|string|max:30',
        'evo_adicion'                => 'nullable|string|max:30',
        'evo_dp'                     => 'nullable|string|max:30',
        'evo_observacion'            => 'nullable|string',
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
                ->where('evo_consecutivo', 'LIKE', "%$buscar%")
                ->orWhere('evo_fecha_diligenciamiento', 'LIKE', "%$buscar%")
                ->orWhere('evo_descripcion_evolucion', 'LIKE', "%$buscar%")
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
     * Obtiene el registro paciente asociado a la evolucio. Historia clinica
     *
     * @return Illuminate\Support\Collection;
     */
    public function getPaciente(){
        return $this->belongsTo(Paciente::class,'evo_id_paciente', 'id');
    }
}
