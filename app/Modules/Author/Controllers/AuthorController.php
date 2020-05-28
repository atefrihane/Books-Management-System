<?php

namespace App\Modules\Author\Controllers;

use App\Contracts\AuthorRepositoryInterface;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    private $authors;

    public function __construct(AuthorRepositoryInterface $authors)
    {
        $this->authors = $authors;
    }
    public function showAuthors()
    {
        return view('Author::showAuthors', ['authors' => $this->authors->all()]);

    }

    public function showAuthor($id)
    {
        $author = $this->authors->fetchById($id);
        if ($author) {

            return view('Author::showAuthor', ['author' => $author]);

        }
        return view('General::showNotFound');

    }
    public function showAddAuthor()
    {

        return view('Author::showAddAuthor');
    }

    public function showUpdateAuthor($id)
    {
        $checkAuthor = $this->authors->fetchById($id);
        if ($checkAuthor) {

            return view('Author::showUpdateAuthor', ['author' => $checkAuthor]);

        }

        return view('General::showNotFound');
    }
}
