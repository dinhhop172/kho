<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    /**
     * categoryRepository
     *
     * @var mixed
     */
    protected $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function paginate()
    {
        return $this->categoryRepository->paginate(5);
    }

    public function getParentCategory()
    {
        return $this->categoryRepository->getParentCategory();
    }

    public function create($request)
    {
        return $this->categoryRepository->create($request->all());
    }

    public function findOrFail($id)
    {
        return $this->categoryRepository->findOrFail($id);
    }

    public function getParentCategoryWithout($id)
    {
        return $this->categoryRepository->getParentCategoryWithout($id);
    }

    public function update($request, $id)
    {
        return $this->categoryRepository->update($request->all(), $id);
    }

    public function destroy($id){
        return $this->categoryRepository->delete($id);
    }
}
