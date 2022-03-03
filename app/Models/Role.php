<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * permissions relationship
     *
     * @return void
     */
    function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id');
    }
}
