<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Repository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

/**
 * Class BookRepository
 * @package App\Repositories\Backend\Book
 */
class ProductRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @param array $filters
     *
     * @return Builder
     */
    public function getProductWith(array $filters): Builder
    {
        $query = $this->model->newQuery();

        if (!empty($filters)) {
            //search
//            if (!empty($filters['search_text'])) {
//                $query->Where(function ($queryString) use ($filters) {
//                    $queryString->where('books.book_id', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.book_name', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.edition', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.author', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.contributor', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.book_description', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.language', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.isbn_number', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('books.book_status', 'like', "%{$filters['search_text']}%");
//                    $queryString->orWhere('book_categories.book_category_name', 'like', "%{$filters['search_text']}%");
//                    //$queryString->orWhere('keywords.keyword_name', 'like', "%{$filters['search_text']}%");
//
//                });
//            }

            //name
            if (!empty($filters['name'])) {
                $query->where('products.name', 'like', "%{$filters['name']}%");
            }
//            //name
//            if (!empty($filters['book_name'])) {
//                $query->where('books.book_name', 'like', "%{$filters['book_name']}%");
//            }
//            //author
//            if (!empty($filters['author'])) {
//                $query->Where(function ($queryString) use ($filters) {
//                    $queryString->where('books.author', 'like', "%{$filters['author']}%");
//                    $queryString->orWhere('books.contributor', 'like', "%{$filters['author']}%");
//                });
//            }
//            //category
//            if (!empty($filters['category'])) {
//                $query->where('book_categories.book_category_id', '=', $filters['category']);
//            }
//            //book_category_id
//            if (!empty($filters['book_category_id'])) {
//                $query->where('books.book_category_id', '=', $filters['book_category_id']);
//            }
//
//            //book_category_name
//            if (!empty($filters['book_category_name'])) {
//                $query->where('book_categories.book_category_name', 'like',"%{$filters['book_category_name']}%");
//            }
//
//
//            //is_sellable
//            if (!empty($filters['is_sellable'])) {
//                $query->where('books.is_sellable', '=', $filters['is_sellable']);
//            }
//            //keyword_name
//            if (!empty($filters['keyword_name'])) {
//                $query->join('keyword_book', 'books.book_id', '=', 'keyword_book.book_id');
//
//                $query->join('keywords', 'keyword_book.keyword_id', '=', 'keywords.keyword_id');
//                $query->where('keywords.keyword_name', 'like', "%{$filters['keyword_name']}%");
//            }
//
//            //isbn_number
//            if (isset($filters['isbn_number']) && $filters['isbn_number']) {
//                $query->where('books.isbn_number', '=', "{$filters['isbn_number']}");
//            }
//
//            //company
//            if (isset($filters['company']) && $filters['company']) {
//                $query->where('books.company_id', '=', "{$filters['company']}");
//            }
//
//            if (isset($filters['company_id']) && $filters['company_id']) {
//                $query->where('books.company_id', '=', "{$filters['company_id']}");
//            }
//
//            //status
//            if (isset($filters['status']) && $filters['status']) {
//                $query->where('books.book_status', '=', "{$filters['status']}");
//            }
//
//            if (isset($filters['book_status']) && $filters['book_status']) {
//                $query->where('books.book_status', '=', "{$filters['book_status']}");
//            }
//
//            //ebook
//            if (isset($filters['is_ebook']) && $filters['is_ebook']) {
//                $query->where('books.is_ebook', '=', "{$filters['is_ebook']}");
//            }
//            //date range
//            if (!empty($filters['start_date']) || !empty($filters['end_date'])) {
//                $query->whereBetween('books.created_at', [$filters['start_date'], $filters['end_date']]);
//            }
//
//            //sorting
//            if (isset($filters['sorting_order']) && $filters['sorting_order']) {
//                $query->orderBy('books.book_id', "{$filters['sorting_order']}");
//            }
//
//            if (isset($filters['book_a_to_z_sorting_order']) && $filters['book_a_to_z_sorting_order']) {
//                $query->orderBy('books.book_name', "{$filters['book_a_to_z_sorting_order']}");
//            }
//
//            if (isset($filters['book_price_sorting_order']) && $filters['book_price_sorting_order']) {
//                $query->orderBy('books.book_price', "{$filters['book_price_sorting_order']}");
//            }
//
//            if ((isset($filters['user_id']) && $filters['user_id'])
//                && (isset($filters['purchased_book_only']) && $filters['purchased_book_only'])) {
//                $query->join('book_user', 'books.book_id', '=', 'book_user.book_id');
//                $query->join('users', 'book_user.user_id', '=', 'users.id');
//                $query->where('book_user.user_id', "=", $filters['user_id']);
//            }

        }

//        $query->whereNull('companies.deleted_at');
//        $query->whereNull('book_categories.deleted_at');
        return $query;

    }

    public function manageKeywords(Book $book, array $pivot): Book
    {
        try {
            $book->keywords()->sync($pivot);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return $book;
    }

    public function getAllEbookTypes()
    {
        return EBookType::all();
    }

}

