<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsReceiptActionController extends Controller
{
    public function complete($id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['manager', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $gr = GoodsReceipt::findOrFail($id);
        $gr->status = 'Completed';
        $gr->save();
        return response()->json($gr);
    }
}
