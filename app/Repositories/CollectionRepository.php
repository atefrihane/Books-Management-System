<?php
namespace App\Repositories;

use App\Contracts\CollectionRepositoryInterface;
use App\Contracts\ImageRepositoryInterface;
use App\Modules\Collection\Models\Collection;

class CollectionRepository implements CollectionRepositoryInterface
{
    private $image;

    public function __construct(ImageRepositoryInterface $image)
    {
        $this->image = $image;

    }
    public function all($type)
    {
        switch ($type) {
            case 'general':
                return Collection::all();
                break;
            case 'countBooks':
                return Collection::withCount('books')->get();
            case 'nested':
                return Collection::with('books')->get();
                break;
        }

    }

    public function store($collection)
    {
        $collectionPhoto = $this->image->uploadImage($collection['photo'], 'collections');

        return Collection::create([
            'photo' => $collectionPhoto,
            'name' => $collection['name'],

        ]);
    }
    public function fetchById($id)
    {
        return Collection::with('books')->find($id);
    }
    public function update($collection)
    {

        $checkCollection = $this->fetchById($collection['id']);

        if ($checkCollection) {
            $collectionPhoto = $checkCollection->photo;
            if ($checkCollection->photo != $collection['photo']) {

                $this->image->deleteFile($checkCollection->photo);
                $collectionPhoto = $this->image->uploadImage($collection['photo'], 'collections');

            }

            return $checkCollection->update([
                'photo' => $collectionPhoto,
                'name' => $collection['name'],

            ]);

        }
        return false;
    }
    public function delete($id)
    {
        $checkCollection = $this->fetchById($id);
        if ($checkCollection) {
            return $checkCollection->delete();
        }
        return false;
    }
}
