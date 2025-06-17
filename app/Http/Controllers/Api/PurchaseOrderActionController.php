<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderActionController extends Controller
{
    public function approve($id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['manager', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $po = PurchaseOrder::findOrFail($id);
        $po->status = 'Disetujui';
        $po->save();
        return response()->json($po);
    }
}
