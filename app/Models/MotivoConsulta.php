<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class MotivoConsulta extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $table = 'motivo_consulta';
    protected $primaryKey = 'id';

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return ["MOTIVO_CONSULTA"];
    }

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
        'mc_consecutivo',
        'id_paciente',
        'url_refraccion',
        'descripcion'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'mc_consecutivo',
        'id_paciente',
        'url_refraccion',
        'descripcion',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'numero_documento.required'                  => 'El Número de Documento del paciente es requerido.',
        'url_refraccion.required'                    => 'La refracción es requerida.',
        'url_refraccion.mimes'                       => 'La refracción debe ser un archivo de tipo: jpg, jpeg, png.',
        'descripcion_motivo_consulta.max'            => 'La descripción de la Historia Clinica no puede superar lo 255 carácteres.'
    ];

    static $rulesStore = [
        'numero_documento'                  => 'required',
        'descripcion_motivo_consulta'       => 'nullable|string|max:255'
    ];

    static function fnRulesUpdate() {
        return [
            'descripcion_motivo_consulta'       => 'nullable|string|max:255'
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
                ->where('mc_consecutivo', 'LIKE', "%$buscar%")
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
     * Obtiene el registro paciente asociado a motivo de consulta. Historia clinica
     *
     * @return Illuminate\Support\Collection;
     */
    public function getPaciente(){
        return $this->belongsTo(Paciente::class,'id_paciente', 'id');
    }
}
