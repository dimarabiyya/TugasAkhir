# Dashboard UI Fix - TODO List

## Task: Fix Admin and Instructor Dashboard UI to show all statistics

### Steps:

- [x] 1. Update DashboardController.php - Admin Method
  - [x] Add: totalTasks, pendingTaskSubmissions, gradedTaskSubmissions
  - [x] Add: totalTransactions, totalRevenue
  - [x] Add: totalAttendances, presentToday
  - [x] Add: monthly enrollments data for charts
  - [x] Add: weekly activity data for charts

- [x] 2. Update DashboardController.php - Instructor Method
  - [x] Add: instructor's task submissions statistics
  - [x] Add: attendance statistics for instructor's courses
  - [x] Add: student progress data for charts

- [x] 3. Update admin.blade.php
  - [x] Fix stat cards to show all available statistics
  - [x] Replace hardcoded chart data with real variables from controller
  - [x] Add more stat cards for Tasks, Transactions, Attendance

- [x] 4. Update instructor.blade.php
  - [x] Fix stat cards to show all available statistics
  - [x] Replace hardcoded chart data with real variables from controller
  - [x] Add more relevant statistics for instructors

### Dependent Files Edited:
- `app/Http/Controllers/DashboardController.php`
- `resources/views/dashboard/admin.blade.php`
- `resources/views/dashboard/instructor.blade.php`

### Completed: All tasks finished!

