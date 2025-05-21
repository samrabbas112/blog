<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function index();
    public function store(array $data);
    public function update(array $data,$id);
    public function delete($id);
    public function show(int $id);

}
