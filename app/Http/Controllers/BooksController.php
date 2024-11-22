<?php

namespace App\Http\Controllers;

use App\Http\Service\NewYorkTimesService;
use Illuminate\Http\Request;
use App\Http\Requests\BestSellerRequest;

class BooksController extends Controller
{
    public $newYorkTimesService;
    
    public function __construct(NewYorkTimesService $newYorkTimesService)
    {
        $this->newYorkTimesService = $newYorkTimesService;
    }

    public function getBestSellers(BestSellerRequest $request)
    {
        if ($request->validated()) {
            return $this->newYorkTimesService->getBestSellersFromInput($request->all());
        }
    }
}