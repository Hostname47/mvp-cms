<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visit;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard() {
        $statistics = $this->stats('today');

        return view('admin.dashboard')
            ->with(compact('statistics'));
    }

    public function statistics(Request $request) {
        $filter = $request->get('filter');

        switch($filter) {
            case 'today':
                return $this->stats('today');
            case 'this-week':
                return $this->stats('this-week');
            case 'this-month':
                return $this->stats('this-month');
            default:
                return $this->stats('lifetimes');
        }
    }

    private function stats($filter) {
        $condition = '';
        switch($filter) {
            case 'today':
                $condition = "DATE(created_at) = '" . date('Y-m-d') . "'";
                break;
            case 'this-week':
                $condition = "DATE(created_at) >= '" . Carbon::now()->startOfWeek() . "'";
                break;
            case 'this-month':
                $condition = "MONTH(created_at) = " . date('m');
                break;
            default:
                $condition = 1;
        }

        return [
            'online-users'=>Visit::where('updated_at', '>=', Carbon::now()->subMinutes(4))->groupBy('visitor_ip')->distinct('visitor_ip')->count(),
            'visitors' => DB::select("SELECT COUNT(DISTINCT visitor_ip) as total FROM visits WHERE $condition")[0]->total,
            'sign-ups' => DB::select("SELECT COUNT(*) as total FROM users WHERE $condition")[0]->total,
            'posts' => DB::select("SELECT COUNT(*) as total FROM posts WHERE $condition")[0]->total,
            'comments' => DB::select("SELECT COUNT(*) as total FROM comments WHERE $condition")[0]->total,
            'claps' => DB::select("SELECT COUNT(*) as total FROM claps WHERE $condition")[0]->total,
            'contact-messages' => DB::select("SELECT COUNT(*) as total FROM contact_messages WHERE $condition")[0]->total,
            'author-requests' => DB::select("SELECT COUNT(*) as total FROM author_requests WHERE $condition")[0]->total,
            'posts-awaiting-review' => DB::select("SELECT COUNT(*) as total FROM posts WHERE $condition AND `status`='awaiting-review'")[0]->total,
            'faqs' => DB::select("SELECT COUNT(*) as total FROM faqs WHERE $condition")[0]->total,
            'reports' => DB::select("SELECT COUNT(*) as total FROM reports WHERE $condition")[0]->total,
            'unauthorized-actions' => DB::select("SELECT COUNT(*) as total FROM authorization_breaks WHERE $condition")[0]->total,
            'newsletter-subscribers' => DB::select("SELECT COUNT(*) as total FROM subscribers WHERE $condition")[0]->total,
        ];
    }
}
