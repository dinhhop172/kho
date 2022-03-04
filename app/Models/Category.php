<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'parent_id'];

    /**
     * children
     *
     * @return void
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * parent
     *
     * @return void
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * scopeWithParentIdNull
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeWithParentIdNull($query)
    {
        return $query->where('parent_id', null);
    }

    /**
     * scopeWithoutId
     *
     * @param  mixed $query
     * @param  mixed $id
     * @return void
     */
    public function scopeWithoutId($query, $id)
    {
        return $id ? $query->where('id', '!=', $id) : null;
    }
}
