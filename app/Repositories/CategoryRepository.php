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

    public function getParentCategory()
    {
        return $this->model->withParentIdNull()->get();
    }

    public function getParentCategoryWithout($id)
    {
        return $this->model->withParentIdNull()->withoutId($id)->get();
    }


}
