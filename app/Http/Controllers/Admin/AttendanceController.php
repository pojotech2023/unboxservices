<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Site;
use App\Models\Wages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class AttendanceController extends Controller
{
    public function index(Request $request, $siteId)
{
    // Fetch the site and site name
    $site = Site::find($siteId);
    $siteName = $site ? $site->site_name : '';

    // Get the filter parameters from the query string
    $month = $request->query('month');
    $week = $request->query('week');
    $date = $request->query('date');

    // Initialize queries for attendance and wages
    $attendanceQuery = Attendance::where('site_id', $siteId);
    $wageQuery = Wages::where('site_id', $siteId);

    $weekDays = [];
    $attendances = collect();
    $wages = $wageQuery->get();  
    $groupedByDate = [];
    $categoryWages = [];
    $totalWages = 0;
    $allCategories = [];
    $totalWeeks = 0;

    // Map wages by category and date
    $wagesByCategory = $wages->keyBy(function ($item) {
        return $item->category . '|' . $item->date;
    });

    if ($month) {
        // If month is provided, set the start and end dates for the month
        $startDate = Carbon::parse($month . '-01');
        $endDate = $startDate->copy()->endOfMonth();

        // Calculate total weeks in the calendar grid
        $firstOfMonth = $startDate->copy()->startOfMonth();
        $lastOfMonth = $startDate->copy()->endOfMonth();
        $calendarStart = $firstOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $calendarEnd = $lastOfMonth->copy()->endOfWeek(Carbon::SATURDAY);
        $totalDays = $calendarStart->diffInDays($calendarEnd) + 1;
        $totalWeeks = ceil($totalDays / 7);

        if ($week) {
            // If week is provided, set the start and end dates for that week
            $weekStart = $calendarStart->copy()->addDays(($week - 1) * 7);
            $weekEnd = $weekStart->copy()->addDays(6);

            for ($d = $weekStart->copy(); $d->lte($weekEnd); $d->addDay()) {
                $weekDays[] = [
                    'label' => $d->format('D d'),
                    'value' => $d->toDateString(),
                ];
            }

            if ($date) {
                // If a specific date is provided, filter attendance by that date
                $attendances = $attendanceQuery->whereDate('date', $date)->get();
            } else {
                // Otherwise, filter attendance for the selected week
                $attendances = $attendanceQuery->whereBetween('date', [$weekStart, $weekEnd])->get();

                // Group attendance by date and calculate total wages
                $groupedByDate = $attendances->groupBy('date')->map(function ($records, $day) use ($wagesByCategory, &$totalWages, &$allCategories) {
                    $dayData = ['date' => $day, 'total' => 0];
                    foreach ($records as $rec) {
                        $key = $rec->category . '|' . Carbon::parse($rec->date)->toDateString();
                        $amount = $wagesByCategory[$key]->amount ?? 0;
                        $dayData[$rec->category] = ($dayData[$rec->category] ?? 0) + $rec->count;
                        $dayData['total'] += $rec->count * $amount;
                        $allCategories[$rec->category] = true;
                    }
                    return $dayData;
                })->values()->toArray();

                $allCategories = array_keys($allCategories);
            }
        } else {
            // If no week is provided, filter attendance for the entire month
            $attendances = $attendanceQuery->whereBetween('date', [$startDate, $endDate])->get();

            // Group attendance by date and calculate total wages
            $groupedByDate = $attendances->groupBy('date')->map(function ($records, $day) use ($wagesByCategory, &$totalWages, &$allCategories) {
                $dayData = ['date' => $day, 'total' => 0];
                foreach ($records as $rec) {
                    $key = $rec->category . '|' . Carbon::parse($rec->date)->toDateString();
                    $amount = $wagesByCategory[$key]->amount ?? 0;
                    $dayData[$rec->category] = ($dayData[$rec->category] ?? 0) + $rec->count;
                    $dayData['total'] += $rec->count * $amount;
                    $allCategories[$rec->category] = true;
                }
                return $dayData;
            })->values()->toArray();

            $allCategories = array_keys($allCategories);
        }
    } else {
        // If no month filter is provided, set default to today's date
        $date = Carbon::today()->toDateString();
        $attendances = $attendanceQuery->whereDate('date', $date)->get();
    }

    // Calculate total wages for each category (non-grouped summary)
    foreach ($attendances as $attendance) {
        $key = $attendance->category . '|' . Carbon::parse($attendance->date)->toDateString();
        $amount = $wagesByCategory[$key]->amount ?? 0;
        $categoryWages[$attendance->category] = ($categoryWages[$attendance->category] ?? 0) + $attendance->count * $amount;
        $totalWages += $attendance->count * $amount;
    }

    // Return the attendance view with the necessary data
    return view('admin.menus.attendance.attendance_management', compact(
        'siteName',
        'siteId',
        'month',
        'week',
        'date',
        'weekDays',
        'attendances',
        'wages',
        'categoryWages',
        'totalWages',
        'groupedByDate',
        'allCategories',
        'totalWeeks'
    ));
}

    public function addWages(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'date'           => 'required|date',
            'amount_kothanar' => 'nullable|numeric',
            'amount_sithal'  => 'nullable|numeric',
            'amount_mesthiri' => 'nullable|numeric',
            'amount_engineer' => 'nullable|numeric',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $categories = ['Kothanar', 'Sithal', 'Mesthiri', 'Engineer'];
        foreach ($categories as $category) {
            $amountField = 'amount_' . strtolower($category);
            if ($request->has($amountField) && !empty($request->$amountField)) {
                Wages::create([
                    'site_id'  => $request->site_id,
                    'category' => $category,
                    'amount'   => $request->$amountField,
                    'date'     => $request->date,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Wages added successfully!.');
    }

    public function addAttendance(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'date'     => 'required|date',
            'count_kothanar' => 'nullable|numeric',
            'count_sithal'   => 'nullable|numeric',
            'count_mesthiri' => 'nullable|numeric',
            'count_engineer' => 'nullable|numeric',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $categories = ['kothanar', 'sithal', 'mesthiri', 'engineer'];
        foreach ($categories as $category) {
            $countField = 'count_' . $category;
            if ($request->has($countField) && !empty($request->$countField)) {
                Attendance::create([
                    'site_id'  => $request->site_id,
                    'category' => ucfirst($category),
                    'count'    => $request->$countField,
                    'date'     => $request->date,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Attendance added successfully!');
    }


    public function getWagesForm($siteId)
    {
        return view('admin.menus.attendance.add_wages', compact('siteId'));
    }

    public function getAttendanceForm($siteId)
    {
        return view('admin.menus.attendance.add_attendance', compact('siteId'));
    }
}
