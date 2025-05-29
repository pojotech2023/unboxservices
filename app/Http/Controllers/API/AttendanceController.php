<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Wages;
use App\Models\Site;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AttendanceController extends Controller
{
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
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
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
        return response()->json([
            'response code' => 200,
            'status' => true,
            'message' => 'Wages added successfully.',
        ]);
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
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
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

        return response()->json([
            'response code' => 200,
            'status' => true,
            'message' => 'Attendance added successfully.',
        ]);
    }

    public function index(Request $request, $siteId)
{
    $site = Site::find($siteId);
    $siteName = $site ? $site->site_name : '';

    $month = $request->query('month');
    $week = $request->query('week');
    $date = $request->query('date');

    $attendanceQuery = Attendance::where('site_id', $siteId);
    $wageQuery = Wages::where('site_id', $siteId);

    $weekDays = [];
    $attendances = collect();
    $wages = collect();
    $groupedByDate = [];
    $categoryWages = [];
    $totalWages = 0;
    $allCategories = [];
    $totalWeeks = 0;

    $wagesByCategory = collect();

    if ($month) {
        $startDate = Carbon::parse($month . '-01');
        $endDate = $startDate->copy()->endOfMonth();

        $firstOfMonth = $startDate->copy()->startOfMonth();
        $lastOfMonth = $startDate->copy()->endOfMonth();
        $calendarStart = $firstOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $calendarEnd = $lastOfMonth->copy()->endOfWeek(Carbon::SATURDAY);
        $totalDays = $calendarStart->diffInDays($calendarEnd) + 1;
        $totalWeeks = ceil($totalDays / 7);

        if ($week) {
            $weekStart = $calendarStart->copy()->addDays(($week - 1) * 7);
            $weekEnd = $weekStart->copy()->addDays(6);

            // Filter wages for the week or date
            if ($date) {
                $wages = $wageQuery->whereDate('date', $date)->get();
            } else {
                $wages = $wageQuery->whereBetween('date', [$weekStart, $weekEnd])->get();
            }

            $wagesByCategory = $wages->keyBy(function ($item) {
                return $item->category . '|' . $item->date;
            });

            for ($d = $weekStart->copy(); $d->lte($weekEnd); $d->addDay()) {
                $weekDays[] = [
                    'label' => $d->format('D d'),
                    'value' => $d->toDateString(),
                ];
            }

            if ($date) {
                $attendances = $attendanceQuery->whereDate('date', $date)->get();
            } else {
                $attendances = $attendanceQuery->whereBetween('date', [$weekStart, $weekEnd])->get();

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
            // No week — get full month wages
            $wages = $wageQuery->whereBetween('date', [$calendarStart, $calendarEnd])->get();
            $wagesByCategory = $wages->keyBy(function ($item) {
                return $item->category . '|' . $item->date;
            });

            $attendances = $attendanceQuery->whereBetween('date', [$startDate, $endDate])->get();

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
        $date = Carbon::today()->toDateString();
        $attendances = $attendanceQuery->whereDate('date', $date)->get();
        $wages = $wageQuery->whereDate('date', $date)->get();

        $wagesByCategory = $wages->keyBy(function ($item) {
            return $item->category . '|' . $item->date;
        });
    }

    foreach ($attendances as $attendance) {
        $key = $attendance->category . '|' . Carbon::parse($attendance->date)->toDateString();
        $amount = $wagesByCategory[$key]->amount ?? 0;
        $categoryWages[$attendance->category] = ($categoryWages[$attendance->category] ?? 0) + $attendance->count * $amount;
        $totalWages += $attendance->count * $amount;
    }

    return response()->json([
        'site_name' => $siteName,
        'site_id' => $siteId,
        'month' => $month,
        'week' => $week,
        'date' => $date,
        'total_weeks' => $totalWeeks,
        'week_days' => $weekDays,
        'attendances' => $attendances,
        'wages' => $wages,
        'category_wages' => $categoryWages,
        'total_wages' => $totalWages,
        'grouped_by_date' => $groupedByDate,
        'all_categories' => $allCategories,
    ]);
}

}
