<?php
/**
 * calendar - Toont kalender met evenementen
 **/
namespace VERHUISKALENDER;

class calendar
{
    function draw_calendar($month,$year)
    {
        $planning = new planning;

        /* draw table */
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        /* table headings */
        $headings = array('Zondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag');
        $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

        /* days and weeks vars now ... */
        $running_day = date('w',mktime(0,0,0,$month,1,$year));
        $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        /* row for week one */
        $calendar.= '<tr class="calendar-row">';

        /* print "blank" days until the first of the current week */
        for($x = 0; $x < $running_day; $x++):
            $calendar.= '<td class="calendar-day-np"> </td>';
            $days_in_this_week++;
        endfor;

        /* keep going with days.... */
        $weekdetails = '';
        for($list_day = 1; $list_day <= $days_in_month; $list_day++):
            $calendar.= '<td class="calendar-day">';
                /* add in the day number */
                $calendar.= '<div class="day-number">'.$list_day.'</div>';

                /* lijst van akties op deze dag en detail gegevens van de akties *
                    De detailgegevens worden verborgen en getoond wanneer op betreffende datum wordt geklijkt
                */
                $datum = sprintf ("%d-%02d-%02d",$year,$month,$list_day);
                $lijst = $planning->OverzichtActiviteiten($datum);
                $details = $planning->DetailsActiviteiten($datum);
                $acties_X = $planning->ActiesPerGebouw($datum,'X');
                $acties_Y = $planning->ActiesPerGebouw($datum,'Y');
                $crowded = $acties_X > 2 || $acties_Y > 2 ?  $crowded = "calendar_crowded" : "";    #maak datumvak geel als te veel inhuizingen
                $weekdetails .= '<tr class="detailrecord" day="' . $list_day . '"><td colspan="7">' . $details . '</td></tr>'; // wordt verborgen en getoond on planning.js
                $class = "showrecord".$list_day;    // maak een class per dag aan, om het mogelijk te maken na klikken op datum een detailoverzicht te krijgen
                $calendar.= '<p class="'.$class. ' ' . $crowded .'">' . $lijst . '</p>';
                
            $calendar.= '</td>';
            if($running_day == 6):
                $calendar.= '</tr>';
                /* detail overzicht tonen =================*/
                $calendar .=  $weekdetails;
                $weekdetails = '';
                /* ========================================*/
                if(($day_counter+1) != $days_in_month):
                    $calendar.= '<tr class="calendar-row">';
                endif;
                $running_day = -1;
                $days_in_this_week = 0;
            endif;
            $days_in_this_week++; $running_day++; $day_counter++;
        endfor;

        /* finish the rest of the days in the week */
        if($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
            endfor;
        endif;

        /* final row */
        $calendar.= '</tr>';

        /* end the table */
        $calendar.= '</table>';
        
        /* all done, return result */
        return $calendar;
    }
}