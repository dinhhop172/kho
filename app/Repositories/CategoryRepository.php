<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     * model
     *
     * @return void
     */
    public function model()
    {
        return Category::class;
    }
}
