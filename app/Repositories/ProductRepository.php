<?php
namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Modules\Article\Models\Article;
use App\Modules\Book\Models\Book;
use App\Modules\Journal\Models\Journal;
use App\Modules\Product\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{

    public function create()
    {

        return Product::create([]);
    }
    public function getDigitalRessources()
    {
        return Product::whereHas('content', function ($q) {
            $q->where('digital_link', '<>', null);
        })->count();
    }

    public function getDigitalDownloadedRessources($type)
    {

        switch ($type) {
            // Tous
            case 1:
                $countDownloads = Product::has('downloads')->count();

                return $countDownloads;
                break;

            case 2:

                // Aujourd'hui

                $countDownloads = Product::has('downloads', function ($q) {
                    $q->whereDate('created_at', '=', Carbon::today());
                })->count();

                return $countDownloads;

                break;
            case 3:
                // Cette semaine

                $countDownloads = Product::has('downloads', function ($q) {
                    $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                })->count();
                return $countDownloads;
                break;
            case 4:
                // Ce mois

                $countDownloads = Product::has('downloads', function ($q) {
                    $q->whereMonth('created_at', Carbon::now()->month);
                })->count();
                return $countDownloads;

                break;
            default:return false;

        }

    }
    // save product
    public function save($saveProduct)
    {

        if (!empty($saveProduct['products'])) {

            foreach ($saveProduct['products'] as &$product) {

                $product['user_id'] = $saveProduct['user_id'];
                $product['type'] = 1; //  1 => saved  / 2 -> downloaded
                $product['created_at'] = Carbon::now();
                $product['updated_at'] = Carbon::now();
            }
        }
        DB::table('user_products')->insert($saveProduct['products']);
        return true;

    }

    //save download

    public function saveDownload($saveProduct)
    {

        if (!empty($saveProduct['products'])) {

            foreach ($saveProduct['products'] as &$product) {

                $product['user_id'] = $saveProduct['user_id'];
                $product['type'] = 2; //  1 => saved  / 2 -> downloaded
                $product['created_at'] = Carbon::now();
                $product['updated_at'] = Carbon::now();
            }
        }
        DB::table('user_products')->insert($saveProduct['products']);
        return true;

    }

    public function getUserSaves($user)
    {
        return $user->products()->wherePivot('type', 1)->get();

    }
    public function search($search)
    {

        return Product::when(isset($search['keyword']), function ($q) use ($search) {

            return $q->whereHasMorph('content', [Book::class, Article::class, Journal::class], function ($q, $type) use ($search) {

                switch ($type) {

                    case Book::class:
                        $q->where(function ($query) use ($search) {
                            $query->where('title', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('description', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('editor', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('isbn', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('published_year', 'LIKE', '%' . $search['keyword'] . '%');

                        });

                        break;
                    case Journal::class:

                        $q->where(function ($query) use ($search) {
                            $query->where('title', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('slug', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('published_year', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('editor', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('director', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('description', 'LIKE', '%' . $search['keyword'] . '%');

                        });

                        break;
                    case Article::class:

                        $q->where(function ($query) use ($search) {
                            $query->where('title', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('description', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('editor', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('isbn', 'LIKE', '%' . $search['keyword'] . '%');
                            $query->Orwhere('published_year', 'LIKE', '%' . $search['keyword'] . '%');

                        });

                        break;
                }

            });

        })->get();

    }

}
