<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];
}
