@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
<script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>

<div class="container">
    <h1>Fixtures for {{ $tournament->name }}</h1>
    <div id='calendar' style="height: 800px;"></div>
    <a href="{{ route('admin.tournaments.show', $tournament) }}" class="btn btn-secondary mt-3">Back to Tournament</a>
</div>
@endsection

@section('scripts')
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        var Calendar = tui.Calendar;

        var calendar = new Calendar('#calendar', {
            defaultView: 'month',
            taskView: true,
            scheduleView: true,
            template: {
                monthDayname: function(dayname) {
                    return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
                },
                monthGridHeader: function(model) {
                    var date = new Date(model.date);
                    var classNames = ['tui-full-calendar-weekday-grid-date '];

                    return '<span class="' + classNames.join(' ') + '">' + date.getDate() + '</span>';
                },
                monthGridFooter: function() {
                    return '';
                },
                monthGridHeaderExceed: function(hiddenSchedules) {
                    return '<span class="calendar-week-dayname-name">+' + hiddenSchedules + '</span>';
                },
                monthGridFooterExceed: function(hiddenSchedules) {
                    return '<span class="calendar-week-dayname-name">+' + hiddenSchedules + '</span>';
                },
                monthSchedule: function(schedule) {
                    return '<span class="calendar-week-dayname-name">' + schedule.title + '</span>';
                },
                monthMoreTitleDate: function(date, dayname) {
                    var day = date.split('.')[2];
                    return '<span class="tui-full-calendar-weekday-grid-date">' + day + '</span> ' + dayname;
                },
                monthMoreClose: function() {
                    return '<span class="tui-full-calendar-weekday-grid-date">Close</span>';
                },
                monthMore: function() {
                    return '<span class="tui-full-calendar-weekday-grid-date">More</span>';
                }
            }
        });

        var schedules = [
            @foreach($fixtures as $fixture)
            {
                id: '{{ $fixture->id }}',
                calendarId: '1',
                title: '{{ $fixture->team1->name }} vs {{ $fixture->team2->name }}',
                category: 'time',
                dueDateClass: '',
                start: '{{ $fixture->match_date }}',
                end: '{{ $fixture->match_date }}',
                location: '{{ $fixture->location }}',
                raw: {
                    referee: '{{ $fixture->referee->name }}'
                }
            },
            @endforeach
        ];

        calendar.createSchedules(schedules);
    });
</script>
@endsection