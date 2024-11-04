<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements  CategoryRepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Category>
     */
    public function index(){
        return Category::all();
    }

    /**
     * @param array<string,mixed> $data
     * @return mixed
     */
    public function store(array $data) {
        return Category::create($data);
    }

    /**
     * @param array<string, mixed> $data
     * @param $id
     * @return mixed
     */
    public function update(array $data,$id){
        // Update the category
        Category::whereId($id)->update($data);

        // Retrieve and return the updated instance
        return Category::findOrFail($id);

    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id){
        Category::destroy($id);
    }

    /**
     * @param int $id
     * @return Category
     */
    public  function  show(int $id): Category
    {
        return  Category::findOrFail($id);
    }

}
