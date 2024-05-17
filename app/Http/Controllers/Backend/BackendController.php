<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use app\Models\User;
use Modules\Page\Models\Page;
class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalPages = Page::count();
        $activeUsers = User::where('status', 1)->count();
        return view('backend.index')
        ->with('totalUsers',$totalUsers)
        ->with('activeUsers',$activeUsers)
        ->with('totalPages',$totalPages);
    }
    
}
