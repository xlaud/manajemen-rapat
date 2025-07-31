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

            $meetingData = Agenda::selectRaw('MONTH(meeting_date) as month, COUNT(*) as count')
            ->whereYear('meeting_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

            $labels = [];
            $data = [];
            $months = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];

            foreach ($months as $monthNumber => $monthName) {
                $labels[] = $monthName;
                $meeting = $meetingData->firstWhere('month', $monthNumber);
                $data[] = $meeting ? $meeting->count : 0;
            }

            $viewData['chartLabels'] = $labels;
            $viewData['chartData'] = $data;

            // Data untuk Pie Chart Kehadiran Bulan Ini (berdasarkan total slot kehadiran)
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $totalGurus = User::where('role', 'guru')->count();

            // Dapatkan semua agenda di bulan ini
            $agendasThisMonth = Agenda::whereYear('meeting_date', $currentYear)
                ->whereMonth('meeting_date', $currentMonth)
                ->get();

            $numberOfMeetings = $agendasThisMonth->count();
            $agendaIdsThisMonth = $agendasThisMonth->pluck('id');

            $gurusHadirCount = 0;
            $gurusIzinCount = 0;
            $gurusTidakHadirCount = 0;

            // Hanya hitung jika ada rapat dan guru
            if ($numberOfMeetings > 0 && $totalGurus > 0) {
                // Total slot presensi yang seharusnya ada
                $totalAttendanceSlots = $totalGurus * $numberOfMeetings;

                if ($agendaIdsThisMonth->isNotEmpty()) {
                    // Hitung jumlah status 'hadir' dan 'izin' secara langsung dari tabel presensi
                    $gurusHadirCount = \App\Models\Presensi::whereIn('agenda_id', $agendaIdsThisMonth)
                        ->where('status', 'hadir')
                        ->count();

                    echo $gurusHadirCount;

                    $gurusIzinCount = \App\Models\Presensi::whereIn('agenda_id', $agendaIdsThisMonth)
                        ->where('status', 'izin')
                        ->count();
                }

                // Tidak hadir adalah sisa dari total slot yang tersedia.
                $gurusTidakHadirCount = $totalAttendanceSlots - $gurusHadirCount - $gurusIzinCount;
                
                // Pastikan tidak ada nilai negatif jika ada anomali data
                if ($gurusTidakHadirCount < 0) {
                    $gurusTidakHadirCount = 0;
                }
            }

            // Mengirim data dengan urutan: Hadir, Izin, Tidak Hadir
            $viewData['attendanceData'] = [$gurusHadirCount, $gurusIzinCount, $gurusTidakHadirCount];
        }

        return view('dashboard', $viewData);
    }
}