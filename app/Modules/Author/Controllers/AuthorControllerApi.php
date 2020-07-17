<?php

namespace App\Modules\Author\Controllers;

use App\Contracts\AuthorRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthor;
use App\Http\Resources\Author as AuthorResource;

class AuthorControllerApi extends Controller
{
    private $authors;

    public function __construct(AuthorRepositoryInterface $authors)
    {
        $this->authors = $authors;
    }
    public function handleAddAuthor(StoreAuthor $request)
    {
        $storeAuthor = $this->authors->store($request->author);
        if ($storeAuthor) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 400]);
    }

    public function handleUpdateAuthor(StoreAuthor $request)
    {

        $updateAuthor = $this->authors->update($request->author);
        if ($updateAuthor) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }

    public function handleDeleteAuthor($id)
    {

        $deleteAuthor = $this->authors->delete($id);
        if ($deleteAuthor) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);
    }
    public function showAuthor($id)
    {
        $checkAuthor = $this->authors->fetchById($id);
        if ($checkAuthor) {
            return response()->json(['status' => 200 ,'author' => new AuthorResource($checkAuthor)]);
        }
        return response()->json(['status' => 404]);
    }

}
