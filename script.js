// Show and hide sections
function showSection(sectionId) {
  const sections = document.querySelectorAll('section');
  sections.forEach((section) => {
    section.classList.remove('active');
  });
  document.getElementById(sectionId).classList.add('active');

  // If the View Attendance section is active, load the attendance list
  if (sectionId === 'view') {
    loadAttendance();
  }

  
  
  // Hide "Mark Attendance" and "View Attendance" if not logged in
  const loggedInUser = sessionStorage.getItem('loggedInUser');
  const markAttendanceLink = document.getElementById('markAttendanceLink');
  const viewAttendanceLink = document.getElementById('viewAttendanceLink');
  const loginLink = document.getElementById('loginLink');
  const registerLink = document.getElementById('registerLink');
  const logoutLink = document.getElementById('logoutLink');

  if (loggedInUser) {
    markAttendanceLink.style.display = 'inline';
    viewAttendanceLink.style.display = 'inline';
    loginLink.style.display = 'none';
    registerLink.style.display = 'none';
    logoutLink.style.display = 'inline';
  } else {
    markAttendanceLink.style.display = 'none';
    viewAttendanceLink.style.display = 'none';
    loginLink.style.display = 'inline';
    registerLink.style.display = 'inline';
    logoutLink.style.display = 'none';
  }
}

// Mark attendance
function markAttendance() {
  const studentName = document.getElementById('studentName').value;
  const subjectName = document.getElementById('subjectName').value;
  const dateTime = new Date().toLocaleString(); // Get current date and time

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
    document.getElementById('markStatus').innerText = "Please enter both student name and subject name.";
  }
}

// Load and display attendance list
function loadAttendance() {
  fetch('view_attendance.php')
    .then(response => response.json())
    .then(data => {
      const attendanceListElement = document.getElementById('attendanceList');
      attendanceListElement.innerHTML = ''; // Clear current list

      if (data.length > 0) {
        data.forEach(entry => {
          const listItem = document.createElement('li');
          listItem.textContent = `${entry.student_name} marked present for ${entry.subject_name} on ${entry.date_time}`;
          attendanceListElement.appendChild(listItem);
        });
      } else {
        attendanceListElement.innerHTML = 'No attendance marked yet.';
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

// Clear all attendance records
function clearAttendance() {
  // Remove all attendance data from the database
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

// Registration logic
document.getElementById('registerForm').addEventListener('submit', function (event) {
  event.preventDefault();
  const username = document.getElementById('regUsername').value;
  const password = document.getElementById('regPassword').value;
  const facultyName = document.getElementById('regFacultyName').value;

  const formData = new FormData();
  formData.append('username', username);
  formData.append('password', password);
  formData.append('faculty_name', facultyName);

  fetch('register.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    document.getElementById('registerStatus').innerText = data;
  })
  .catch(error => {
    console.error('Error:', error);
  });
});

// Login logic
document.getElementById('loginForm').addEventListener('submit', function (event) {
  event.preventDefault();
  const username = document.getElementById('loginUsername').value;
  const password = document.getElementById('loginPassword').value;

  const formData = new FormData();
  formData.append('username', username);
  formData.append('password', password);

  fetch('login.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    if (data === 'Login successful!') {
      sessionStorage.setItem('loggedInUser', username);
      showSection('home');
    }
    document.getElementById('loginStatus').innerText = data;
  })
  .catch(error => {
    console.error('Error:', error);
  });
});

// Logout logic
function logout() {
  sessionStorage.removeItem('loggedInUser');
  showSection('home');
}
