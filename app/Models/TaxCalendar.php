<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'title',
        'description',
        'theme', // color code
        'art_work',
        'is_active',
    ];

    public function days(): HasMany
    {
        return $this->hasMany(TaxCalendarDay::class);
    }

    public static function monthName($month_number){
        $dt = \DateTime::createFromFormat('!m', $month_number);
        return $dt->format('F');
    }


    public static function getCalendar(){
        return self::where('is_active', true)->orderBy('year')->orderBy('month')->get();
    }

    protected static function daysAndEventsObject($days){
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

    public static function buildCalendar($calendar) {
        $year = $calendar->year;
        $month = intval($calendar->month);
        $daysArray = self::daysAndEventsObject($calendar->days);
        $numberOfDays = count($daysArray);

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
            $eventsCount = $dayInfo['events_count'];
             if ($dayOfWeek == 7) {
                  $dayOfWeek = 0;
                  $calendar .= "</tr><tr>";
   
             }
             
             $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
             $date = "$year-$month-$currentDayRel";
             $eventClass = $eventsCount > 0 ? 'has-e':'';
             if ($date == date("Y-m-d")){
              $calendar .= "<td class='day todday' rel='$date'>
              <span class='day-date $eventClass'>$currentDay</span><br>
              <span class='holiday'>$holiday</span>
              </td>";
             }
             else{
              $calendar .= "<td class='day' rel='$date'>
              <span class='day-date $eventClass'>$currentDay</span><br>
              <span class='holiday'>$holiday</span>
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
