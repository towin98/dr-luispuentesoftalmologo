<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class CargarArchivo extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return ["CARGAR_ARCHIVO"];
    }

    protected $table = 'cargar_archivos';
    protected $primaryKey = 'id';

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
        'id_paciente',
        'ruta_archivo',
        'consecutivo_archivo',
        'observacion'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'id_paciente',
        'ruta_archivo',
        'consecutivo_archivo',
        'observacion',
        'created_at',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'numero_documento.required'  => 'El Número de Documento del paciente es requerido.',
        'ruta_archivo.required'      => 'El archivo a cargar es requerido.',
        'ruta_archivo.mimes'         => 'El archivo cargado debe ser tipo: pdf',
        'observacion.string'         => 'El valor de la Observación del archivo cargado no puede superar lo 255 carácteres.'
    ];

    static $rulesStore = [
        'numero_documento'         => 'required',
        'ruta_archivo'             => 'required|file|mimes:pdf',
        'observacion'              => 'nullable|string|max:255'
    ];

    static $rulesUpdate = [
        'numero_documento'         => 'required',
        'ruta_archivo'             => 'nullable',
        'observacion'              => 'nullable|string|max:255'
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
                ->where('consecutivo_archivo', 'LIKE', "%$buscar%")
                ->orWhere('created_at', 'LIKE', "%$buscar%")
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
     * Obtiene el registro del paciente asociado al archivo cargado. Historia clinica
     *
     * @return Illuminate\Support\Collection;
     */
    public function getPaciente(){
        return $this->belongsTo(Paciente::class,'id_paciente', 'id');
    }
}
