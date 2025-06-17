<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceActionController extends Controller
{
    public function paid($id)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['manager', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $invoice = Invoice::findOrFail($id);
        $invoice->status = 'Paid';
        $invoice->save();
        return response()->json($invoice);
    }
}
