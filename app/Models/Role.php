<?php

namespace App\Models;

use DateTimeInterface;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    protected $guarded = [];

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
}
