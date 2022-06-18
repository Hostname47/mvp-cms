<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\{User,Visit};
use Carbon\Carbon;
use App\View\Components\Admin\User\SignupUser;

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

    public function signups(Request $request) {
        $data = $request->validate([
            'filter'=>['required', Rule::in(['today','this-week','this-month','lifetime'])],
            'skip'=>'required|numeric',
            'take'=>'required|numeric',
        ]);

        $users = User::withoutGlobalScopes();

        switch($data['filter']) {
            case 'today':
                $users = $users->whereDate('created_at', Carbon::today());
                break;
            case 'this-week':
                $users = $users->where('created_at', '>=', Carbon::now()->startOfWeek());
                break;
            case 'this-month':
                $users = $users->whereRaw("MONTH(created_at) = " . date('m'));
                break;
            case 'lifetime':
                /** we don't have to add any condition */
                break;
        }
        $users = $users->orderBy('created_at', 'desc')->skip($data['skip'])->take($data['take']+1)->get();

        $hasmore = $users->count() > $data['take'];
        $users = $users->take($data['take']);
        $payload = "";

        foreach($users as $user) {
            $user_component = (new SignupUser($user));
            $user_component = $user_component->render(get_object_vars($user_component))->render();
            $payload .= $user_component;
        }

        return [
            'users'=>$payload,
            'hasmore'=>$hasmore,
            'count'=>$users->count()
        ];
    }
}
