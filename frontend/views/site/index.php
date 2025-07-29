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
      height: 'auto',
      navLinks: false,
      businessHours: true,
      editable: false,
      selectable: true,
      selectMirror: true,
      dayMaxEvents: true,
      weekends: true,
      slotLabelFormat: {hour: '2-digit',
          minute: '2-digit',
          hour12: false
      },
      eventTimeFormat: {hour: '2-digit',
          minute: '2-digit',
          hour12: false
      },
      
      
      
      events: [ ]
    });

    calendar.render();
  });
JS, \yii\web\View::POS_END);
$this->registerCss('
/* Calendar Styling */
.fc-view-harness [class*="fc-"] {
    color: black;
    text-decoration: none;
}



');
?>
<div class="card">
    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>
