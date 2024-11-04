<?php

namespace App\Services;

use App\Interfaces\TagRepositoryInterface;
use App\Models\Tag;
use Yajra\DataTables\Facades\DataTables;

class TagService
{
    public function __construct(protected TagRepositoryInterface $tagRepository)
    {

    }

    public function store(array $data): Tag
    {
        return $this->tagRepository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->tagRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->tagRepository->delete($id);
    }

    public function index()
    {

        return $this->tagRepository->index();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $user = auth('admin')->user();

        $data = $this->index();

        return DataTables::of($data)
            ->addColumn('action', function ($row) use ($user) {
                $editUrl = route('tags.create', ['id' => $row->id]);
                $deleteUrl = route('api.v1.tags.destroy', [$row->id]);

                // Build action buttons based on user permissions
                $actionBtn = '';

                if (!$user->can('edit tags')) {
                    // User cannot edit, can only delete
                    $actionBtn .= '<a href="#" data-id="' . $row->id . '" class="delete-tag btn btn-danger btn-sm">Delete</a>';
                } elseif (!$user->can('delete tags')) {
                    // User can edit but cannot delete
                    $actionBtn .= '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>';
                } else {
                    // User can edit and delete
                    $actionBtn .= '<a href="' . $editUrl . '" class="edit btn btn-success btn-sm">Edit</a>
                    <a href="#" data-id="' . $row->id . '" class="delete-tag btn btn-danger btn-sm">Delete</a>';
                }

                return $actionBtn; // Return the built action buttons
            })
            ->rawColumns(['action']) // Allow HTML rendering in the 'action' column
            ->make(true);
    }


}
