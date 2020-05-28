<?php
namespace App\Repositories;

use App\Contracts\BookRepositoryInterface;
use App\Contracts\ImageRepositoryInterface;
use App\Modules\Book\Models\Book;

class BookRepository implements BookRepositoryInterface
{
    private $image;

    public function __construct(ImageRepositoryInterface $image)
    {
        $this->image = $image;

    }
    public function all()
    {
        return Book::all();
    }
    public function getFirstBook()
    {
        return Book::first();

    }
    public function getLastId()
    {
        return $this->getFirstBook() ? $id = $this->all()->last()->id + 1 : 1;

    }
    public function store($book)
    {
        dd($book);
        $bookPhoto = $this->image->uploadImage($book['photo'], 'books');

        $book['digital_link'] ? $bookPdf = $this->image->uploadPdf($book['digital_link'], 'books/pdf') : $bookPdf = null;
        $nextId = $this->getLastId();

        $newBook = Book::create([
            'photo' => $bookPhoto,
            'active' => $book['active'],
            'title' => $book['title'],
            'slug' => str_slug($book['title'] . ' ' . $nextId, '-'),
            'published_year' => $book['published_year'],
            'editor' => $book['editor'],
            'count_pages' => $book['count_pages'],
            'isbn' => $book['isbn'],
            'description' => $book['description'],
            'height' => $book['height'],
            'width' => $book['width'],
            'thickness' => $book['thickness'],
            'weight' => $book['weight'],
            'paper_price' => $book['paper_price'],
            'digital_price' => $book['digital_price'],
            'photo' => $bookPhoto,
            'digital_link' => $bookPdf,

        ]);

        $newBook->categories()->attach(array_column($book['categories'], 'id'));

        $newBook->languages()->attach(array_column($book['languages'], 'id'));

        (isset($book['articles'])) ? $newBook->articles()->attach($book['articles']) : '';

        $newBook->authors()->attach($book['authors']);

        $newProduct = $this->products->create();
        $newBook->product()->save($newProduct);

        return true;

    }
    public function fetchById($id)
    {

        return Book::find($id);

    }
    public function update($book)
    {

        $checkBook = $this->fetchById($book['id']);

        if ($checkBook) {
            $bookPhoto = $checkBook->photo;
            $bookPdf = $checkBook->digital_link;

            if ($checkBook->photo != $book['photo']) {
                $this->image->deleteFile($checkBook->photo);
                $bookPhoto = $this->image->uploadImage($book['photo'], 'books');

            }
            if (!$book['digital_link'] && $checkBook->digital_link) {
                $this->image->deleteFile($checkBook->digital_link);
                $bookPdf = null;

            }

            if ($book['digital_link'] && $book['digital_link'] != $checkBook->digital_link) {
                $this->image->deleteFile($checkBook->digital_link);
                $bookPdf = $this->image->uploadPdf($book['digital_link'], 'books/pdf');

            }

            $checkBook->update([
                'photo' => $bookPhoto,
                'active' => $book['active'],
                'title' => $book['title'],
                'slug' => str_slug($book['title'] . ' ' . $book['id'], '-'),
                'published_year' => $book['published_year'],
                'editor' => $book['editor'],
                'count_pages' => $book['count_pages'],
                'isbn' => $book['isbn'],
                'description' => $book['description'],
                'height' => $book['height'],
                'width' => $book['width'],
                'thickness' => $book['thickness'],
                'weight' => $book['weight'],
                'paper_price' => $book['paper_price'],
                'digital_price' => $book['digital_price'],
                'photo' => $bookPhoto,
                'digital_link' => $bookPdf,

            ]);

            $checkBook->categories()->sync(array_column($book['categories'], 'id'));

            $checkBook->languages()->sync(array_column($book['languages'], 'id'));
            (isset($book['articles'])) ? $checkBook->articles()->sync($book['articles']) : '';

            $checkBook->authors()->sync($book['authors']);
            return true;

        }
        return false;

    }
    public function delete($id)
    {
        $checkBook = $this->fetchById($id);
        if ($checkBook) {
            $checkBook->product()->delete();
            $checkBook->delete();
            return true;
        }
        return false;
    }

    public function getRecentBooks()
    {
        return Book::OrderBy('created_at', 'DESC')->get();

    }

    public function getLegacyBooks()
    {
        return Book::OrderBy('published_year', 'ASC')->get();

    }

    public function filterByCategory($name)
    {

        return Book::whereHas('categories', function ($q) use ($name) {
            $q->where('categories.name', $name);
        })->get();
    }

    public function searchBooks($search)
    {

        return Book::when(isset($search['keyword']), function ($q) use ($search) {

            return $q->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWhere('description', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWhere('editor', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWhere('isbn', 'LIKE', '%' . $search['keyword'] . '%');
                $query->orWherehas('authors', function ($queryAuthors) use ($search) {
                    $queryAuthors->where('first_name', 'LIKE', '%' . $search['keyword'] . '%');
                    $queryAuthors->orWhere('last_name', 'LIKE', '%' . $search['keyword'] . '%');
                });

            });

        })
            ->when(isset($search['category']), function ($queryCategory) use ($search) {

                return $queryCategory->whereHas('categories', function ($nestedCategory) use ($search) {
                    $nestedCategory->where('categories.name', $search['category']);
                });
            })

            ->when(isset($search['language']), function ($queryLanguage) use ($search) {

                return $queryLanguage->whereHas('languages', function ($nestedLanguage) use ($search) {
                    $nestedLanguage->where('languages.name', $search['language']);
                });
            })
            ->when(isset($search['filter']), function ($queryFilter) use ($search) {

                if ($search['filter'] == 'legacy') {

                    return $queryFilter->OrderBy('published_year', 'ASC');
                }

                return $queryFilter->OrderBy('created_at', 'DESC');

            })

            ->get();

    }

}
