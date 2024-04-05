<?php

namespace App\Http\Controllers\Calendar;

use App\Http\Controllers\Controller;
use App\Models\TaxCalendar;
use App\Models\TaxCalendarDay;
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
        $calendar = TaxCalendar::find($id);
        $year = $calendar->year;
        $month = intval($calendar->month);
        $daysArray = $this->daysAndEventsObject($calendar->days);
        return view('user.calendar', [
            'calendar' => $calendar,
            'html' => $this->buildCalendar($month, $year, count($daysArray), $daysArray),
            'days' => $daysArray
        ]);
    }

    public function calendar_day($id)
    {
        $calendarDay = TaxCalendarDay::find($id);
        $calendar = TaxCalendar::find($calendarDay->tax_calendar_id);
        $year = $calendar->year;
        $month = TaxCalendar::monthName($calendar->month);
        $event = json_decode(json_encode(['title' => null, 'content' => null]));
        if(count($calendarDay->events) > 0){
            $event = $calendarDay->events[0];
        }
        return view('user.calendar_day', [
            'event' => $event,
            'title' => $calendarDay->day . ' ' . $month . ' ' . $year,
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

    protected function daysAndEventsObject($days){
        $daysAndEvents = [];
        foreach( $days as $key => $day):
            $entry = [
                'id' => $day->id,
                'day' => $day->day,
                'holiday' => $day->holiday,
                'title' => $day->title,
                'events_count' => count($day->events),
            ];
            $daysAndEvents[$key] = $entry;
        endforeach;
        return $daysAndEvents;
    }

    protected function buildCalendar($month, $year, $numberOfDays, $daysArray) {
        if(count($daysArray) < $numberOfDays){
            abort(400, "Month must contain full number of days");
        }
        $daysOfWeek = array('Sun','Mon','Tue','Wed','Thur','Fri','Sat');
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
        $dateComponents = getdate($firstDayOfMonth);
        $dayOfWeek = $dateComponents['wday'];
        $calendar = "<table class='calendar'>";
        $calendar .= "<tr>";
      
        foreach($daysOfWeek as $day) {
             $calendar .= "<th class='header'>$day</th>";
        } 
   
        $currentDay = 1;
        $calendar .= "</tr><tr>";
   
        if ($dayOfWeek > 0) { 
             $calendar .= "<td colspan='$dayOfWeek' class='not-month'>&nbsp;</td>"; 
        }
        
        $month = str_pad($month, 2, "0", STR_PAD_LEFT);
     
        while ($currentDay <= $numberOfDays) {
    
            $dayInfo = $daysArray[$currentDay - 1];
            $holiday = $dayInfo['holiday'];
            $day_id = $dayInfo['id'];
            $eventsCount = $dayInfo['events_count'];

             if ($dayOfWeek == 7) {
                  $dayOfWeek = 0;
                  $calendar .= "</tr><tr>";
   
             }
             
             $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
             $date = "$year-$month-$currentDayRel";
             $link = route('e.tax.calendars.day.show', ['id' => $day_id]);
             $eventBtn = $eventsCount > 0 ? "<a class='btn-sm app-btn-secondary' target='_blank' href='$link'>Manage Events</a>" : "<a class='btn-sm app-btn-secondary' target='_blank' href='$link'>Manage Events</a>";
             if ($date == date("Y-m-d")){
              $calendar .= "<td class='day today' rel='$date'>
              <span class='today-date'>$currentDay</span><br>
              <span class='holiday'>$holiday</span><br>
              <span class='event'>$eventBtn</span>
              </td>";
             }
             else{
              $calendar .= "<td class='day' rel='$date'>
              <span class='day-date'>$currentDay</span><br>
              <span class='holiday'>$holiday</span><br>
              <span class='event'>$eventBtn</span>
              </td>";
             }
             
             $currentDay++;
             $dayOfWeek++;
   
        }
           
        if ($dayOfWeek != 7) { 
        
             $remainingDays = 7 - $dayOfWeek;
             $calendar .= "<td colspan='$remainingDays' class='not-month'>&nbsp;</td>"; 
   
        }
        
        $calendar .= "</tr>";
        $calendar .= "</table>";
   
        return $calendar;
   }
}
