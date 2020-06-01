<?php

namespace App\Modules\Book\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\BookRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    private $books, $languages, $categories, $authors, $articles;

    public function __construct(
        BookRepositoryInterface $books,
        LanguageRepositoryInterface $languages,
        CategoryRepositoryInterface $categories,
        AuthorRepositoryInterface $authors,
        ArticleRepositoryInterface $articles

    ) {
        $this->books = $books;
        $this->languages = $languages;
        $this->categories = $categories;
        $this->authors = $authors;
        $this->articles = $articles;
    }

    public function showBooks()
    {
      
        return view('Book::showBooks', ['books' => $this->books->all()]);

    }

    public function showAddBook()
    {

        return view('Book::showAddBook', [
            'languages' => $this->languages->all(),
            'categories' => $this->categories->all(),
            'authors' => $this->authors->all(),
            'articles' => $this->articles->all(),
        ]);
    }

    public function showBook($id)
    {
        
        $checkBook = $this->books->fetchById($id);

        if ($checkBook) {
            return view('Book::showBook', ['book' => $checkBook]);
        }
        return view('General::showNotFound');

    }

    public function showUpdateBook($id)
    {
        $checkBook = $this->books->fetchById($id);

        if ($checkBook) {
            return view('Book::showUpdateBook', [
                'book' => $checkBook,
                'languages' => $this->languages->all(),
                'categories' => $this->categories->all(),
                'authors' => $this->authors->all(),
                'articles' => $this->articles->all(),
            ]);
        }
        return view('General::showNotFound');

    }
}
