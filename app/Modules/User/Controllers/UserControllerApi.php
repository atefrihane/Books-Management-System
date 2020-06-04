<?php

namespace App\Modules\User\Controllers;

use App\Contracts\ArticleRepositoryInterface;
use App\Contracts\BookRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\StoreAdmin;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateAdminProfile;
use App\Http\Requests\UpdateProfile;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Journal as JournalResource;
use App\Http\Resources\User as UserResource;

class UserControllerApi extends Controller
{
    private $users, $books, $journals, $articles, $categories;
    public function __construct(UserRepositoryInterface $users,
        BookRepositoryInterface $books,

        ArticleRepositoryInterface $articles,
        CategoryRepositoryInterface $categories
    ) {
        $this->users = $users;
        $this->books = $books;

        $this->articles = $articles;
        $this->categories = $categories;

    }

    public function handleLogin(LoginUser $request)
    {

        $response = $this->users->login($request->all());
        switch ($response['status']) {
            case 200:
                return response()->json([
                    'token' => $response['token'],
                    'user' => new UserResource($response['user']),
                    'books' => BookResource::collection($this->books->all()),
                    'articles' => ArticleResource::collection($this->articles->all()),
                    'status' => $response['status'],
                ]);
                break;
            case 404:
                return response()->json(['status' => $response['status']]);

        }

    }

    public function handleRegister(StoreUser $request)
    {

        $this->users->register($request->except(['password_confirmation']));
        return response()->json(['status' => 200]);

    }

    public function handleRegisterBackoffice(StoreAdmin $request)
    {
        $user = $request->user;
        unset($user['password_confirmation']);

        $this->users->register($user);
        return response()->json(['status' => 200]);

    }
    public function handleUpdateProfile(UpdateProfile $request, $id)
    {
        isset($request->user) ? $user = $request->user : $user = $request->all();

        $response = $this->users->update($user);

        switch (isset($response['user'])) {

            case 0:
                $response['status'] == -1 ? $status = 404 : $status = 405;
                return response()->json(['status' => $status]);
                break;

            case 1:
                return response()->json(['status' => 200, 'user' => new UserResource($response['user'])]);

                break;

        }

    }

    public function handleUpdateAdminProfile(UpdateAdminProfile $request)
    {

        $response = $this->users->update($request->user);

        switch (isset($response['user'])) {

            case 0:
                $response['status'] == -1 ? $status = 404 : $status = 405;
                return response()->json(['status' => $status]);
                break;

            case 1:
                return response()->json(['status' => 200, 'user' => new UserResource($response['user'])]);

                break;

        }

    }

    public function handleDeleteUser($id)
    {
        $deletedUser = $this->users->delete($id);
        if ($deletedUser) {
            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function showUserHomeDetails()
    {
        return response()->json(['status' => 200,
            'recentBooks' => BookResource::collection($this->books->getRecentBooks()),
            'legacyBooks' => BookResource::collection($this->books->getLegacyBooks()),
            'journals' => JournalResource::collection($this->journals->all()),
            'articles' => ArticleResource::collection($this->articles->all()),
            'categories' => CategoryResource::collection($this->categories->all()),
        ]);

    }
    public function showUserDetails($id)
    {
        $checkUser = $this->users->fetchById($id);
        if ($checkUser) {
            return response()->json(['status' => 200,
                'user' => (new UserResource($checkUser)),
            ]);

        }

        return response()->json(['status' => 404]);

    }
    public function handleBlockUser($id)
    {
        $checkUser = $this->users->block($id);
        if ($checkUser) {
            return response()->json(['status' => 200]);

        }

        return response()->json(['status' => 404]);
    }

    public function handleUnblockUser($id)
    {

        $checkUser = $this->users->unblock($id);
        if ($checkUser) {
            return response()->json(['status' => 200]);

        }

        return response()->json(['status' => 404]);
    }
}
