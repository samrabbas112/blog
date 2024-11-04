<?php

namespace App\Repositories;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagRepository implements TagRepositoryInterface
{

    /**
     * @return Collection<int, Tag>
     */
    public function  index(): Collection
    {
        return Tag::all();
    }

    /**
     * @param int $id
     * @return Tag
     */
    public  function  show(int $id): Tag
    {
        return  Tag::findOrFail($id);
    }

    /**
     * @param array $data
     * @return Tag
     */
    public  function  store(array $data): Tag
    {
        return Tag::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Tag
     */
    public function update(array $data,int $id): Tag
    {
        Tag::whereId($id)->update($data);
        return  Tag::findOrFail($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Tag::destroy($id);
    }
}
