<?php

namespace App\Modules\Book\Controllers;

use App\Http\Controllers\Controller;
use App\Contracts\BookRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;
use App\Contracts\CollectionRepositoryInterface;

class BookController extends Controller
{
    private $books, $languages, $categories, $authors, $articles,$collections;

    public function __construct(
        BookRepositoryInterface $books,
        LanguageRepositoryInterface $languages,
        CategoryRepositoryInterface $categories,
        AuthorRepositoryInterface $authors,
        ArticleRepositoryInterface $articles,
        CollectionRepositoryInterface $collections

    ) {
        $this->books = $books;
        $this->languages = $languages;
        $this->categories = $categories;
        $this->authors = $authors;
        $this->articles = $articles;
        $this->collections = $collections;
    }

    public function showBooks()
    {
      
        return view('Book::showBooks', ['books' => $this->books->all('countCategories')]);

    }

    public function showAddBook()
    {

        return view('Book::showAddBook', [
  
            'categories' => $this->categories->all(),
            'authors' => $this->authors->all(),
            'articles' => $this->articles->all(),
            'collections' => $this->collections->all('general')
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
            
                'categories' => $this->categories->all(),
                'authors' => $this->authors->all(),
                'articles' => $this->articles->all(),
                'collections' => $this->collections->all('general')
            ]);
        }
        return view('General::showNotFound');

    }
}
