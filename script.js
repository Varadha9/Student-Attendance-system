// Show and hide sections
function showSection(sectionId) {
  const sections = document.querySelectorAll('section');
  sections.forEach((section) => {
    section.classList.remove('active');
  });

  const activeSection = document.getElementById(sectionId);
  if (activeSection) {
    activeSection.classList.add('active');
  }

  // If View Attendance section is opened, load data
  if (sectionId === 'view') {
    loadAttendance();
  }
}

// Mark attendance (connected to PHP backend)
function markAttendance() {
  const studentName = document.getElementById('studentName').value;
  const subjectName = document.getElementById('subjectName').value;
  const dateTime = new Date().toLocaleString();

  if (studentName && subjectName) {

    const formData = new FormData();
    formData.append('student_name', studentName);
    formData.append('subject_name', subjectName);
    formData.append('date_time', dateTime);

    fetch('mark_attendance.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      document.getElementById('markStatus').innerText = data;
      document.getElementById('studentName').value = '';
      document.getElementById('subjectName').value = '';
      loadAttendance();
    })
    .catch(error => {
      console.error('Error:', error);
    });

  } else {
    document.getElementById('markStatus').innerText =
      "Please enter both student name and subject name.";
  }
}

// Load attendance list from database
function loadAttendance() {
  fetch('view_attendance.php')
    .then(response => response.json())
    .then(data => {

      const attendanceListElement =
        document.getElementById('attendanceList');

      attendanceListElement.innerHTML = '';

      if (data.length > 0) {
        data.forEach(entry => {
          const listItem = document.createElement('li');
          listItem.textContent =
            entry.student_name +
            " marked present for " +
            entry.subject_name +
            " on " +
            entry.date_time;

          attendanceListElement.appendChild(listItem);
        });
      } else {
        attendanceListElement.innerHTML =
          "No attendance marked yet.";
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Clear attendance records
function clearAttendance() {
  fetch('clear_attendance.php')
    .then(response => response.text())
    .then(data => {
      console.log(data);
      loadAttendance();
    })
    .catch(error => {
      console.error('Error:', error);
    });
}