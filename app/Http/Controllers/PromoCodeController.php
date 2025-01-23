<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\PromoCode\PromoCodeContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function __construct(public PromoCodeContract $promoCodeContract) {
    }

    public function activate(Request $request, string $code): JsonResponse
    {
        $result = $this->promoCodeContract->activate($request->attributes->get('user_id'), $code);

        return response()->json([
            'success' => $result->isSuccess,
            'message' => $result->message,
        ]);
    }
}
