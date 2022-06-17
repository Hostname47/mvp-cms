<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visit;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard() {
        $statistics = [
            'online-users'=>Visit::where('updated_at', '>=', Carbon::now()->subMinutes(4))->groupBy('visitor_ip')->distinct('visitor_ip')->count(),
            'visitors' => DB::select('SELECT COUNT(DISTINCT visitor_ip) as total FROM visits WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'sign-ups' => DB::select('SELECT COUNT(*) as total FROM users WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'posts' => DB::select('SELECT COUNT(*) as total FROM posts WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'comments' => DB::select('SELECT COUNT(*) as total FROM comments WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'claps' => DB::select('SELECT COUNT(*) as total FROM claps WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'contact-messages' => DB::select('SELECT COUNT(*) as total FROM contact_messages WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'author-requests' => DB::select('SELECT COUNT(*) as total FROM author_requests WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'posts-under-review' => DB::select('SELECT COUNT(*) as total FROM posts WHERE status=\'under-review\' AND DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'faqs' => DB::select('SELECT COUNT(*) as total FROM faqs WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'reports' => DB::select('SELECT COUNT(*) as total FROM reports WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'unauthorized-actions' => DB::select('SELECT COUNT(*) as total FROM authorization_breaks WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
            'newsletter-subscribers' => DB::select('SELECT COUNT(*) as total FROM subscribers WHERE DATE(created_at) = \''. date('Y-m-d').'\'')[0]->total,
        ];
        
        return view('admin.dashboard')
            ->with(compact('statistics'));
    }
}
