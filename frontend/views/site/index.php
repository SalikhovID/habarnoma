<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

$this->registerJs(<<<JS
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      selectable: true,
      
      events: [ ]
    });

    calendar.render();
  });
JS, \yii\web\View::POS_END);
?>


<div id='calendar'></div>