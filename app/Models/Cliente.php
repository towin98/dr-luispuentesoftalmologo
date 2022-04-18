<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'id';

    public function getdepartamentoAttribute($value)
    {
        return strtoupper($value);
    }

    public function getmunicipioAttribute($value)
    {
        return strtoupper($value);
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
        'tipo_documento',
        'numero_documento',
        'nombre',
        'apellido',
        'tipo_cliente',
        'razon_social',
        'nit',
        'correo',
        'celular',
        'direccion',
        'departamento',
        'municipio',
        'fecha_nacimiento',
        'edad',
        'id_p_ocupacion',
        'foto',
        'id_p_eps',
        'fecha_creacion'
    ];

    /**
     * Los atributos que deberían estar visibles.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'tipo_documento',
        'numero_documento',
        'nombre',
        'apellido',
        'tipo_cliente',
        'razon_social',
        'nit',
        'correo',
        'celular',
        'direccion',
        'departamento',
        'municipio',
        'fecha_nacimiento',
        'edad',
        'id_p_ocupacion',
        'foto',
        'id_p_eps',
        'fecha_creacion',
        'updated_at'
    ];

    static $messages = [
        'tipo_documento.required'       => 'El tipo de documento es requerido.',
        'tipo_documento.max'            => 'El tipo de documento no puede superar los 10 carácteres.',
        'tipo_documento.filled'         => 'El tipo de documento no puede ser vacío.',
        'numero_documento.required'     => 'El número de documento es requerido.',
        'numero_documento.max'          => 'El número de documento no puede superar los 20 carácteres.',
        'numero_documento.filled'       => 'El número de documento no puede ser vacío.',
        'numero_documento.unique'       => 'El número de documento ya existe.',
        'nombre.required'               => 'El nombre es requerido.',
        'nombre.max'                    => 'El nombre no puede superar los 25 carácteres.',
        'nombre.filled'                 => 'El nombre no puede ser vacío.',
        'apellido.required'             => 'El apellido es requerido.',
        'apellido.max'                  => 'El apellido no puede superar los 25 carácteres.',
        'apellido.filled'               => 'El apellido no puede ser vacío.',
        'tipo_cliente.required'         => 'El tipo de cliente es requerido.',
        'tipo_cliente.filled'           => 'El tipo de cliente no puede ser vacío.',
        'tipo_cliente.in'               => 'El tipo de cliente debe ser persona_juridica o persona_natural.',
        'razon_social.required'         => 'La Razón Social es requerido.',
        'razon_social.max'              => 'La Razón Social no puede superar los 30 carácteres.',
        'razon_social.filled'           => 'La Razón Social no puede ser vacía.',
        'razon_social.unique'           => 'La Razón Social ya existe.',
        'nit.required'                  => 'El Nit es requerido.',
        'nit.max'                       => 'El Nit no puede superar los 30 carácteres.',
        'nit.filled'                    => 'El Nit no puede ser vacío.',
        'nit.unique'                    => 'El nit ya existe.',
        'correo.required'               => 'El correo es requerido.',
        'correo.max'                    => 'El correo no puede superar los 255 carácteres.',
        'correo.email'                  => 'El correo ingresado no es valido.',
        'correo.filled'                 => 'El correo no puede ser vacío.',
        'correo.unique'                 => 'El correo ya existe.',
        'celular.required'              => 'El número de celular es requerido.',
        // 'celular.integer'               => 'El número de celular deben ser datos númericos.',
        'celular.max'                   => 'El número de celular no puede superar los 15 dígitos.',
        'celular.filled'                => 'El número de celular no puede ser vacío.',
        'direccion.required'            => 'La dirección es requerido.',
        'direccion.max'                 => 'La dirección no puede superar los 30 carácteres.',
        'direccion.filled'              => 'La dirección no puede ser vacía.',
        'departamento.required'         => 'El Departamento es requerido.',
        'departamento.max'              => 'El Departamento no puede superar los 30 carácteres.',
        'departamento.filled'           => 'El Departamento no puede ser vacío.',
        'municipio.required'            => 'El Municipio es requerido.',
        'municipio.max'                 => 'El Municipio no puede superar los 30 carácteres.',
        'municipio.filled'              => 'El Municipio no puede ser vacío.',
        'fecha_nacimiento.required'     => 'La Fecha de Nacimiento es requerida.',
        'fecha_nacimiento.date_format'  => 'La fecha de nacimiento debe cumplir el formato: Y-m-d.',
        'edad.required'                 => 'La Edad es requerida.',
        'edad.integer'                  => 'La Edad debe ser un dato númerico.',
        'id_p_ocupacion.required'       => 'La Ocupación es requerida.',
        'id_p_ocupacion.integer'        => 'La Ocupación debe ser un dato númerico.',
        'id_p_ocupacion.filled'         => 'La Ocupación no puede ser vacía.',
        'foto.max'                      => 'La foto no puede superar los 255 carácteres.',
        'id_p_eps.required'             => 'La EPS es requerida.',
        'id_p_eps.integer'              => 'La EPS debe ser un dato númerico.',
        'fecha_creacion.required'       => 'La fecha de creación es requerida.',
        'fecha_creacion.date_format'    => 'La fecha de creacion debe cumplir el formato: Y-m-d.',
        'fecha_creacion.filled'         => 'La fecha de creación no puede ser vacía.',
    ];

    static $rulesStorePersonaJuridica = [
        'tipo_documento'        => 'required|string|max:10',
        'numero_documento'      => 'required|unique:cliente|string|max:20',
        'nombre'                => 'required|string|max:25',
        'apellido'              => 'required|string|max:25',
        'tipo_cliente'          => 'required|in:persona_juridica,persona_natural',
        'razon_social'          => 'required|string|unique:cliente|max:30',
        'nit'                   => 'required|unique:cliente|string|max:30',
        'correo'                => 'required|unique:cliente|email|max:255',
        'celular'               => 'required|string|max:15',
        'direccion'             => 'required|string|max:30',
        'departamento'          => 'required|string|max:30',
        'municipio'             => 'required|string|max:30',
        'fecha_nacimiento'      => 'nullable', // campos no se validan para este tipo de persona.
        'edad'                  => 'nullable', // campos no se validan para este tipo de persona.
        'id_p_ocupacion'        => 'nullable', // campos no se validan para este tipo de persona.
        'foto'                  => 'nullable', // campos no se validan para este tipo de persona.
        'id_p_eps'              => 'nullable', // campos no se validan para este tipo de persona.
        'fecha_creacion'        => 'required|date'
    ];

    static function fnRulesUpdatePersonaJuridica($user) {
        return [
            'tipo_documento'        => 'required|filled|string|max:10',
            'numero_documento'      => 'required|unique:cliente,numero_documento,'.$user->id.'|filled|string|max:20',
            'nombre'                => 'required|filled|string|max:25',
            'apellido'              => 'required|filled|string|max:25',
            'tipo_cliente'          => 'required|filled|in:persona_juridica,persona_natural',
            'razon_social'          => 'required|unique:cliente,razon_social,'.$user->id.'|filled|string|max:30',
            'nit'                   => 'required|unique:cliente,nit,'.$user->id.'|filled|string|max:30',
            'correo'                => 'required|unique:cliente,correo,'.$user->id.'|filled|email|max:255',
            'celular'               => 'required|filled|string',
            'direccion'             => 'required|filled|string|max:30',
            'departamento'          => 'required|filled|string|max:30',
            'municipio'             => 'required|filled|string|max:30',
            'fecha_nacimiento'      => 'nullable', // Campos no se validan para este tipo de persona.
            'edad'                  => 'nullable', // Campos no se validan para este tipo de persona.
            'id_p_ocupacion'        => 'nullable', // Campos no se validan para este tipo de persona.
            'foto'                  => 'nullable', // Campos no se validan para este tipo de persona.
            'id_p_eps'              => 'nullable', // Campos no se validan para este tipo de persona.
        ];
    }

    static $rulesStorePersonaNatural = [
        'tipo_documento'        => 'required|string|max:10',
        'numero_documento'      => 'required|unique:cliente|string|max:20',
        'nombre'                => 'required|string|max:25',
        'apellido'              => 'required|string|max:25',
        'tipo_cliente'          => 'required|in:persona_juridica,persona_natural',
        'razon_social'          => 'nullable',
        'nit'                   => 'nullable',
        'correo'                => 'required|unique:cliente|email|max:255',
        'celular'               => 'required|string|max:15',
        'direccion'             => 'required|string|max:30',
        'departamento'          => 'required|string|max:30',
        'municipio'             => 'required|string|max:30',
        'fecha_nacimiento'      => 'required|date_format:Y-m-d',
        'edad'                  => 'required|integer',
        'id_p_ocupacion'        => 'required|integer',
        // 'foto'                  => 'nullable|string|max:255',
        'id_p_eps'              => 'required|integer',
        'fecha_creacion'        => 'required|date'
    ];

    static function fnRulesUpdatePersonaNatural($user) {
        return [
            'tipo_documento'        => 'required|filled|string|max:10',
            'numero_documento'      => 'required|unique:cliente,numero_documento,'.$user->id.'|filled|string|max:20',
            'nombre'                => 'required|filled|string|max:25',
            'apellido'              => 'required|filled|string|max:25',
            'tipo_cliente'          => 'required|filled|in:persona_juridica,persona_natural',
            'razon_social'          => 'nullable',
            'nit'                   => 'nullable',
            'correo'                => 'required|unique:cliente,correo,'.$user->id.'|filled|email|max:255',
            'celular'               => 'required|filled|string|max:15',
            'direccion'             => 'required|filled|string|max:30',
            'departamento'          => 'required|filled|string|max:30',
            'municipio'             => 'required|filled|string|max:30',
            'fecha_nacimiento'      => 'required|filled|date_format:Y-m-d',
            'edad'                  => 'required|filled|integer',
            'id_p_ocupacion'        => 'required|filled|integer',
            'foto'                  => 'nullable',
            'id_p_eps'              => 'required|filled|integer',
        ];
    }

    /**
     * Scope para realizar una búsqueda mixta.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $buscar Valor a buscar
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscarPersonaJuridica($query, $buscar) {
        if($buscar) {
            return $query
                ->where('nit', 'LIKE', "%$buscar%")
                ->orWhere('razon_social', 'LIKE', "%$buscar%")
                ->orWhere('nombre', 'LIKE', "%$buscar%")
                ->orWhere('numero_documento', 'LIKE', "%$buscar%")
                ->orWhere('correo', 'LIKE', "%$buscar%")
                ->orWhere('direccion', 'LIKE', "%$buscar%")
                // ->orWhere('celular', 'LIKE', "%$buscar%")
                ->orWhere('municipio', 'LIKE', "%$buscar%")
                ->orWhere('updated_at', 'LIKE', "%$buscar%");
        }
    }

    /**
     * Scope para realizar una búsqueda mixta.
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param string $buscar Valor a buscar
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscarPersonaNatural($query, $buscar) {
        if($buscar) {
            return $query
                ->where('numero_documento', 'LIKE', "%$buscar%")
                ->orWhere('nombre', 'LIKE', "%$buscar%")
                ->orWhere('apellido', 'LIKE', "%$buscar%")
                ->orWhere('correo', 'LIKE', "%$buscar%")
                ->orWhere('celular', 'LIKE', "%$buscar%")
                ->orWhere('municipio', 'LIKE', "%$buscar%")
                // ->orWhere('fecha_nacimiento', 'LIKE', "%$buscar%")
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
}
