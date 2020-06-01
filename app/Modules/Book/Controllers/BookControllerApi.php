<?php

namespace App\Modules\Book\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBook;
use App\Http\Requests\UpdateBook;
use App\Modules\Book\Models\Book;
use App\Http\Requests\StoreAuthor;
use App\Http\Controllers\Controller;
use App\Contracts\BookRepositoryInterface;
use App\Contracts\AuthorRepositoryInterface;
use App\Http\Resources\Book as BookResource;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\LanguageRepositoryInterface;

class BookControllerApi extends Controller
{
    private $books, $languages, $categories, $authors;

    public function __construct(
        BookRepositoryInterface $books,
        LanguageRepositoryInterface $languages,
        CategoryRepositoryInterface $categories,
        AuthorRepositoryInterface $authors
    ) {
        $this->books = $books;
        $this->languages = $languages;
        $this->categories = $categories;
        $this->authors = $authors;
    }

    public function handleSaveBook(StoreBook $request)
    {
       
       
        $saveBook = $this->books->store($request->all());
        return response()->json(['status' => 200]);
    }
    public function handleUpdateBook(StoreBook $request)
    {
       
        $saveBook = $this->books->update($request->all());
        return response()->json(['status' => 200]);

    }
    public function handleDeleteBook($id)
    {

        $deleteBook = $this->books->delete($id);
        if ($deleteBook) {
            return response()->json(['status' => 200]);

        }
        return response()->json(['status' => 404]);
    }
    public function handleFilterBooksByCategory($name)
    {
        $booksByCategory = $this->books->filterByCategory($name);
        return response()->json(['status' => 200, 'books' => BookResource::collection($booksByCategory)]);
    }
    public function showBook($id)
    {
        $book = $this->books->fetchById($id);
        if ($book) {

            return response()->json(['status' => 200, 'book' => (new BookResource($book))]);

        }
        return response()->json(['status' => 404]);
    }
    public function showBooks()
    {
        return response()->json(['status' => 200, 'books' => BookResource::collection($this->books->all())]);
    }
    public function showFilterBooks(Request $request)
    {

        if (!empty($request->query())) {

            switch ($request->query('filter')) {
                case 'legacy':
                    return response()->json(['status' => 200, 'books' => BookResource::collection($this->books->getLegacyBooks())]);
                    break;

                case 'recent':

                    return response()->json(['status' => 200, 'books' => BookResource::collection($this->books->getRecentBooks())]);
                    break;
                default:
                    return $this->showBooks();

            }

        }
        return $this->showBooks();
    }

    public function handleSearchBooks(Request $request)
    {

        $search = [
            'keyword' => $request->query('keyword'),
            'language' => $request->query('language'),
            'category' => $request->query('category'),
            'filter' => $request->query('filter')
        ];
      
        return response()->json(['status' => 200,
            'books' => BookResource::collection($this->books->searchBooks($search))]);

    }
}
