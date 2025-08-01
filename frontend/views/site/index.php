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
      slotLabelFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      },
      
      // Dynamic event loading
      events: function(fetchInfo, successCallback, failureCallback) {
        // Format dates for the API request
        var startDate = fetchInfo.start.toISOString().split('T')[0];
        var endDate = fetchInfo.end.toISOString().split('T')[0];
        
        // Make AJAX request to get events
        fetch('/site/get-events?start_date=' + startDate + '&end_date=' + endDate)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            // Pass the events to FullCalendar
            successCallback(data);
          })
          .catch(error => {
            console.error('Error fetching events:', error);
            failureCallback(error);
          });
      },
      
      // Optional: Add loading indicator
      loading: function(bool) {
        if (bool) {
          // Show loading indicator
          document.getElementById('calendar').style.opacity = '0.5';
        } else {
          // Hide loading indicator
          document.getElementById('calendar').style.opacity = '1';
        }
      },
      
      // Optional: Handle event click
      eventClick: function(info) {
        console.log('Event clicked:', info.event);
        // You can add custom event click handling here
      }
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

/* Loading state styling */
#calendar {
    transition: opacity 0.3s ease;
}

/* Optional: Custom event styling */
.fc-event {
    border-radius: 4px;
    border: none;
}
');
?>

<div class="card">
    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>