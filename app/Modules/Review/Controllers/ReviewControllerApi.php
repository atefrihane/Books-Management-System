<?php

namespace App\Modules\Review\Controllers;

use App\Http\Requests\StoreReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateReviewStatus;
use App\Contracts\ReviewRepositoryInterface;
use App\Http\Resources\Review as ReviewResource;

class ReviewControllerApi extends Controller
{
    private $reviews;
    public function __construct(ReviewRepositoryInterface $reviews)
    {
        $this->reviews = $reviews;
    }

    public function handleStoreReview(StoreReview $request)
    {
        $storeReview = $this->reviews->store($request->all());
        if ($storeReview) {
            return response()->json(['status' => 200]);

        }
        return response()->json(['status' => 400]);
    }

    public function handleUpdateStatus(UpdateReviewStatus $request)
    {
       
        $updateReviewStatus = $this->reviews->updateStatus($request->all());
        if ($updateReviewStatus) {

            return response()->json(['status' => 200]);
        }
        return response()->json(['status' => 404]);

    }

    public function showUserReviews($id)
    {

        $showUserReviews = $this->reviews->getUserReviews($id);
        if ($showUserReviews) {

            return response()->json(['status' => 200, 'reviews' => ReviewResource::collection($showUserReviews)]);
        }
        return response()->json(['status' => 404]);

    }

}
