<?php

namespace App\Interfaces;

interface TagRepositoryInterface
{
    public function index();
    public function store(array $data);
    public function update(array $data,int $id);
    public function delete(int $id);
    public function show(int $id);
}
