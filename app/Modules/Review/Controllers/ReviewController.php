<?php

namespace App\Modules\Review\Controllers;

use App\Contracts\ReviewRepositoryInterface;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    private $reviews;
    public function __construct(ReviewRepositoryInterface $reviews)
    {
        $this->reviews = $reviews;
    }
    public function showReviews()
    {
        return view('Review::showReviews', ['reviews' => $this->reviews->all()]);
    }
}
