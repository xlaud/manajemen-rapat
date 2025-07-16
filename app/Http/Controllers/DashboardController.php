<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dokumentasi;
use App\Models\Notula;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $viewData = [];

        // DATA UNTUK SEMUA ROLE (ADMIN & GURU)
        $today = Carbon::today()->toDateString();
        $now_time = Carbon::now()->format('H:i:s');

        $viewData['agendaTerdekat'] = Agenda::where(function ($query) use ($today, $now_time) {
                $query->where('meeting_date', $today)->where('meeting_time', '>=', $now_time);
            })->orWhere('meeting_date', '>', $today)
            ->orderBy('meeting_date', 'asc')
            ->orderBy('meeting_time', 'asc')
            ->first();

        // DATA KHUSUS UNTUK ADMIN
        if ($user->role === 'admin') {
            $viewData['totalAgendas'] = Agenda::count();
            $viewData['totalNotulas'] = Notula::count();
            $viewData['totalGurus'] = User::where('role', 'guru')->count();
            $viewData['totalDokumentasi'] = Dokumentasi::count();
        }

        return view('dashboard', $viewData);
    }
}