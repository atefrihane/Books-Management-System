<?php
namespace App\Repositories;

use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\ImageRepositoryInterface;
use App\Modules\Author\Models\Author;

class AuthorRepository implements AuthorRepositoryInterface
{
    private $image;

    public function __construct(ImageRepositoryInterface $image)
    {
        $this->image = $image;

    }
    public function all()
    {
        return Author::all();
    }
    public function store($author)
    {

        $authorPhoto = $this->image->uploadImage($author['photo'], 'authors');

        return Author::create([
            'photo' => $authorPhoto,
            'first_name' => $author['first_name'],
            'last_name' => $author['last_name'],
            'biography' => $author['biography'],
        ]);

    }
    public function fetchById($id)
    {
        return Author::find($id);
    }
    public function update($author)
    {

        $checkAuthor = $this->fetchById($author['id']);

        if ($checkAuthor) {

            $authorPhoto = $checkAuthor->photo;

            if (trim($checkAuthor->photo) != trim($author['photo'])) {

                $this->image->deleteFile($checkAuthor->photo);

                $authorPhoto = $this->image->uploadImage($author['photo'], 'authors');

            }

            return $checkAuthor->update([
                'photo' => $authorPhoto,
                'first_name' => $author['first_name'],
                'last_name' => $author['last_name'],
                'biography' => $author['biography'],

            ]);

        }
    }
    public function delete($id)
    {
        $checkAuthor = $this->fetchById($id);
        if ($checkAuthor) {
            return $checkAuthor->delete();

        }
        return false;
    }
}
