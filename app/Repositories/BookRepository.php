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

        $bookPhoto = $this->image->uploadImage($book['photo'], 'books');
        isset($book['pdf_link']) ? $pdfBook = $this->image->uploadFile($book['pdf_link'], '/img/books/pdf') : $pdfBook = null;

        isset($book['audio_link']) ? $audioBook = $this->image->uploadFile($book['audio_link'], '/img/books/audio') : $audioBook = null;

        $bookCategories = json_decode($book['categories']);
        $newBook = Book::create([
            'photo' => $bookPhoto,
            'active' => $book['active'],
            'title' => $book['title'],
            'subject' => $book['subject'],
            'why_to_read' => $book['why_to_read'],
            'quotes' => $book['quotes'],
            'audio_link' => $audioBook,
            'pdf_link' => $pdfBook,
            'author_id' => $book['author_id'],

        ]);

        $newBook->categories()->attach(array_column($bookCategories, 'id'));

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
            $bookAudio = $checkBook->audio_link;
            $bookPdf = $checkBook->pdf_link;
            if ($checkBook->photo != $book['photo']) {
                $this->image->deleteFile($checkBook->photo);
                $bookPhoto = $this->image->uploadImage($book['photo'], 'books');

            }

            if (isset($book['audio_link'])) {
                $this->image->deleteFile($checkBook->audio_link);
                $bookAudio = $this->image->uploadFile($book['audio_link'], '/img/books/audio/');
            }

            if (isset($book['pdf_link'])) {
                $this->image->deleteFile($checkBook->pdf_link);
                $bookPdf = $this->image->uploadFile($book['pdf_link'], '/img/books/pdf/');
            }
            $bookCategories = json_decode($book['categories']);

            $checkBook->update([
                'photo' => $bookPhoto,
                'active' => $book['active'],
                'title' => $book['title'],
                'subject' => $book['subject'],
                'why_to_read' => $book['why_to_read'],
                'quotes' => $book['quotes'],
                'audio_link' => $bookAudio,
                'pdf_link' => $bookPdf,
                'author_id' => $book['author_id'],
    
            ]);
       

            $checkBook->categories()->sync(array_column($bookCategories, 'id'));

            return true;

        }
        return false;

    }
    public function delete($id)
    {
        $checkBook = $this->fetchById($id);
        if ($checkBook) {

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
