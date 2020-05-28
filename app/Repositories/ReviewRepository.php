<?php
namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ReviewRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Modules\Review\Models\Review;

class ReviewRepository implements ReviewRepositoryInterface
{
    protected $users, $products;
    public function __construct(UserRepositoryInterface $users, ProductRepositoryInterface $products)
    {
        $this->users = $users;
        $this->products = $products;
    }
    public function all()
    {
        return Review::all();
    }

    public function countReviews()
    {
        return Review::count();
    }
    public function getLastId()
    {
        return $this->countReviews() > 0 ? $id = $this->all()->last()->id + 1 : 1;

    }

    public function store($review)
    {
        return Review::create($review);

    }

    public function updateStatus($review)
    {
        $checkReview = $this->fetchById($review['id']);
        if ($checkReview) {
            return $checkReview->update(['active' => $review['status']]);
        }
        return false;

    }

    public function getUserReviews($id)
    {
        $checkUser = $this->users->fetchById($id);
        if ($checkUser) {
            return Review::where('user_id', $id)->get();

        }
        return false;

    }
    public function fetchById($id)
    {
        return Review::find($id);
    }
    public function update($id)
    {}
    public function delete($id)
    {}
}
