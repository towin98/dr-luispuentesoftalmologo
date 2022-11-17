<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
// use OwenIt\Auditing\Auditable;
// use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Authenticatable // implements AuditableContract
{
    use HasApiTokens;
    use Notifiable;
    use HasRoles;
    use HasFactory;
    // use Auditable;

    // /**
    //  * {@inheritdoc}
    //  */
    // public function generateTags(): array
    // {
    //     return ["USUARIOS"];
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Reglas de validación para el recurso crear.
     *
     * @var array
     */
    public static $messagesValidators = [
        'password.required'                   => 'La contraseña es requerido.',
        'password.min'                        => 'La contraseña debe tener minimo 8 carácteres.',
        'email.required'                      => 'El correo electronico es requerido.',
        'email.email'                         => 'El correo electronico no es válido.',
        'email.max'                           => 'El correo electronico no puede superar los 50 carácteres.',
    ];

    /**
     * Mensajes de validación al cambiar contraseña.
     *
     * @var array
     */
    public static $messagesValidatorsCambioClave = [
        // Cambio clave
        'claveActual.required'                => 'La clave actual es requerida.',
        'claveActual.min'                     => 'La contraseña Actual debe tener minimo 8 carácteres.',
        'password.required'                   => 'La contraseña Nueva es requerida.',
        'password.min'                        => 'La contraseña Nueva debe tener minimo 8 carácteres.',
        'password.confirmed'                  => 'La confirmación de contraseña no coincide.',
        'password_confirmation.required'      => 'El campo de confirmación de contraseña es obligatorio',
        'password_confirmation.min'           => 'La contraseña de confirmación debe tener minimo 8 carácteres.',
    ];
}
