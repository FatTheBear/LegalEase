<?php
namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Http\Request;

class LawyerController extends Controller
{
    /**
     * Tìm kiếm luật sư theo chuyên ngành
     */
    public function index(Request $request)
    {
        $query = Lawyer::whereHas('user', function ($q) {
            $q->where('role', 'lawyer')->where('status', 'active');
        });

        if ($request->has('specialty')) {
            $query->where('specialty', 'like', '%' . $request->specialty . '%');
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $lawyers = $query->with('user')->get();
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Xem profile luật sư
     */
    public function show($id)
    {
        $lawyer = Lawyer::whereHas('user', function ($q) {
            $q->where('role', 'lawyer')->where('status', 'active');
        })->with('user')->findOrFail($id);

        return view('lawyers.show', compact('lawyer'));
    }
}