<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\TaxCalendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function calendars()
    {
        return view('user.calendars', [
            'all' => $this->getCalendars(),
        ]);
    }

    public function calendar($id)
    {
        return view('user.calendar', [
            'all' => [],
        ]);
    }

    public function delete($id)
    {
        return view('user.calendars', [
            'all' => [],
        ]);
    }

    protected function getCalendars(){
        return TaxCalendar::orderBy('year')->orderBy('month')->get();
    }
}
