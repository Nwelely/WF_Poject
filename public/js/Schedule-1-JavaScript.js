document.addEventListener('DOMContentLoaded', function() {
    const scheduleData = [
        { day: 'Monday', morning: { time: '8:00 AM - 10:00 AM', activity: 'Weight Training' }, afternoon: { time: '4:00 PM - 6:00 PM', activity: 'Functional Training' }, evening: { time: '6:30 PM - 8:00 PM', activity: 'Group Fitness Class' } },
        { day: 'Tuesday', morning: { time: '9:00 AM - 11:00 AM', activity: 'Cardio Workout' }, afternoon: { time: '3:00 PM - 5:00 PM', activity: 'Strength Training' }, evening: { time: '6:00 PM - 7:30 PM', activity: 'Yoga Session' } },
        { day: 'Wednesday', morning: { time: '8:00 AM - 10:00 AM', activity: 'Functional Training' }, afternoon: { time: '4:00 PM - 6:00 PM', activity: 'Group Fitness Class' }, evening: { time: '7:00 PM - 8:30 PM', activity: 'Bootcamp' } },
        { day: 'Thursday', morning: { time: '9:00 AM - 11:00 AM', activity: 'Strength Training' }, afternoon: { time: '3:00 PM - 5:00 PM', activity: 'Cardio Workout' }, evening: { time: '6:00 PM - 7:30 PM', activity: 'Pilates' } },
        { day: 'Friday', morning: { time: '8:00 AM - 10:00 AM', activity: 'Weight Training' }, afternoon: { time: '4:00 PM - 6:00 PM', activity: 'Functional Training' }, evening: { time: '6:30 PM - 8:00 PM', activity: 'Group Fitness Class' } },
        { day: 'Saturday', morning: { time: '9:00 AM - 11:00 AM', activity: 'Cardio Workout' }, afternoon: { time: '3:00 PM - 5:00 PM', activity: 'Strength Training' }, evening: { time: '6:00 PM - 7:30 PM', activity: 'Yoga Session' } },
        { day: 'Sunday', morning: null, afternoon: null, evening: null } 
        
        
    ];

    const scheduleContainer = document.getElementById('schedule-container');
    const scheduleTable = document.createElement('table');
    scheduleTable.classList.add('schedule-table');

    const tableHeaders = ['Day', 'Morning', 'Afternoon', 'Evening'];
    const tableHeaderRow = document.createElement('tr');
    tableHeaders.forEach(headerText => {
        const th = document.createElement('th');
        th.textContent = headerText;
        tableHeaderRow.appendChild(th);
    });
    scheduleTable.appendChild(tableHeaderRow);

    scheduleData.forEach(day => {
        const row = document.createElement('tr');
        const dayCell = document.createElement('td');
        dayCell.textContent = day.day;
        row.appendChild(dayCell);
        ['morning', 'afternoon', 'evening'].forEach(timeSlot => {
            const td = document.createElement('td');
            const slot = day[timeSlot];
            if (slot) {
                td.innerHTML = `${slot.time}<br>${slot.activity}`;
            } else {
                td.textContent = '-';
            }
            row.appendChild(td);
        });
        scheduleTable.appendChild(row);
    });

    scheduleContainer.appendChild(scheduleTable);
});
window.onload = function() {
    function moveButtonBeneathTable() {
        var scheduleContainer = document.getElementById('schedule-container');
        var bookNowBtn = document.getElementById('book-now-btn');

        scheduleContainer.parentNode.insertBefore(bookNowBtn, scheduleContainer.nextSibling);
    }

    moveButtonBeneathTable();
};



// Check and apply stored dark mode preference on page load
document.addEventListener('DOMContentLoaded', function () {
    const isDarkMode = localStorage.getItem('darkModeEnabled') === 'true';
    const darkModeButton = document.querySelector('.darkmode-button');
    
    if (isDarkMode) {
      document.body.classList.add('dark-mode');
      darkModeButton.textContent = 'Light Mode';
    } else {
      document.body.classList.remove('dark-mode');
      darkModeButton.textContent = 'Dark Mode';
    }
  });