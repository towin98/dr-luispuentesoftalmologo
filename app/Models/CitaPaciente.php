<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaPaciente extends Model
{
    use HasFactory;


    protected $table = 'cita_paciente';
    protected $primaryKey = 'id';

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
        'tipo_consulta',
        'fecha_cita',
        'hora_cita',
        'observacion',
        'asistio'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'id_paciente',
        'tipo_consulta',
        'fecha_cita',
        'hora_cita',
        'observacion',
        'asistio',
        'created_at',
        'updated_at',
        'getPaciente'
    ];

    static $messages = [
        'tipo_consulta.required'        => 'El tipo de Consulta es requerido.',
        'numero_documento.required'     => 'El número de documeto es requerido.',
        'fecha_cita.required'           => 'La Fecha de la cita es requerido.',
        'fecha_cita.date_format'        => 'La fecha de cita no coincide con el formato Y-m-d',
        'hora_cita.required'            => 'La Hora de la cita es requerido.',
        'hora_cita.date_format'         => 'La Hora de cita no coincide con el formato H:i',
        'observacion.max'               => 'La observación de la cita no puede superar lo 255 carácteres.'
    ];

    static $rulesStore = [
        'tipo_consulta'    => 'required',
        'numero_documento' => 'required',
        'fecha_cita'       => 'required|date_format:Y-m-d',
        'hora_cita'        => 'required|date_format:H:i',
        'observacion'      => 'nullable|max:255',
        'asistio'          => 'nullable|in:SI,NO'
    ];

    /**
     * Obtiene el registro paciente asociado al antecedente. Historia clinica
     *
     * @return Illuminate\Support\Collection;
     */
    public function getPaciente(){
        return $this->belongsTo(Paciente::class,'id_paciente', 'id');
    }
}
