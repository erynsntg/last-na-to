<?php
$xmlFile = 'records.xml';
$records = [];

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    foreach ($xml->record as $rec) {
        $records[] = [
            'student_number' => (string)$rec->student_number,
            'first_name'     => (string)$rec->first_name,
            'last_name'      => (string)$rec->last_name,
            'program'        => (string)$rec->program,
            'year_level'     => (string)$rec->year_level,
        ];
    }
} else {
    $error = "No records found. The XML file does not exist.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Records</title>
  <style>
   body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background-color: #f8f8f8;
  overflow: hidden; 
}

.header {
  height: 96px;
  background-color: #A8132D;
  display: flex;
  align-items: center;
  padding-left: 46px;
  color: white;
  font-size: 28px;
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
}

.sidebar {
  position: fixed;
  top: 96px;
  left: 0;
  width: 252px;
  height: calc(100% - 96px);
  background-color: rgba(168, 19, 45, 1);
  padding-top: 30px;
  display: flex;
  flex-direction: column;
}

.sidebar a {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  color: #FFF;
  text-decoration: none;
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
  font-weight: 600;
  transition: background 0.3s;
}

.sidebar a.active,
.sidebar a:hover {
  background-color: #c53249;
}

.main-content {
  margin-left: 252px;
  height: calc(100vh - 96px); 
  padding-top: 24px;
  display: flex;
  justify-content: center;
  align-items: start;
  overflow: hidden;
}

.content-box {
  background-color: white;
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0 0 10px #ccc;
  width: 90%;
  max-width: 1000px;
  max-height: calc(100vh - 160px); 
  overflow-y: auto; /* ito yung scrollbar inside the box */
}

h2 {
  text-align: center;
  margin-bottom: 30px;
}

.search-bar {
  width: 50%;
  display: flex;
  align-items: center;
  margin: 0 auto 20px auto;
  background-color: #ddd;
  border-radius: 30px;
  padding: 8px 16px;
}

.search-bar input {
  border: none;
  background: none;
  outline: none;
  flex: 1;
  font-size: 16px;
}

.buttons {
  text-align: center;
  margin-bottom: 20px;
}

.buttons button {
  padding: 10px 20px;
  margin: 0 10px;
  border: none;
  border-radius: 6px;
  font-size: 14px;
  color: white;
  cursor: pointer;
  font-weight: bold;
}

.buttons .add {
  background-color: #28a745;
}

.buttons .update {
  background-color: #ffc107;
  
}

.buttons .delete {
  background-color: #dc3545;
}

.table-container {
  border: 1px solid #ccc;
  border-radius: 6px;
}

table {
  width: 100%;
  border-collapse: collapse;
  table-layout: auto;
  text-align: center;
}

th, td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ccc;
}

th {
  background-color: #000;
  color: white;
}

@media (max-width: 600px) {
  .search-bar {
    width: 90%;
  }

  .buttons button {
    display: block;
    width: 100%;
    margin: 10px 0;
  }
}
  </style>

  <script>
    function searchTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#studentTable tr:not(:first-child)");
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? "" : "none";
      });
    }
  </script>
</head>
<body>

<div class="header">
  <img src="bsu.png" alt="BSU Logo" style="width: 62px; height: 64px; margin-right: 20px;">
  Bulacan State University
</div>

<div class="sidebar">
  <a class="active" href="home.php"><span>🏠</span> &nbsp;Home</a>
  <a href="about.html"><span>ℹ️</span> &nbsp;About</a>
  <a href="acc.php"><span>⚙️</span> &nbsp;Account Settings</a>
  <a href="index.html"><span>🔓</span> &nbsp;Log out</a>
</div>

<div class="main-content">
  <div class="content-box">
    <h2>List of Student Information</h2>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search..." onkeyup="searchTable()">
      <span>🔍</span>
    </div>

    <div class="buttons">
      <button class="add" onclick="location.href='add.php'">Add</button>
      <button class="update" onclick="location.href='update.php'">Update</button>
      <button class="delete" onclick="location.href='delete.php'">Delete</button>
    </div>

    <?php if (!empty($records)) : ?>
      <div class="table-container">
        <table id="studentTable">
          <tr>
            <th>Student Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Program</th>
            <th>Year Level</th>
          </tr>
          <?php foreach ($records as $rec): ?>
            <tr>
              <td><?= htmlspecialchars($rec['student_number']) ?></td>
              <td><?= htmlspecialchars($rec['first_name']) ?></td>
              <td><?= htmlspecialchars($rec['last_name']) ?></td>
              <td><?= htmlspecialchars($rec['program']) ?></td>
              <td><?= htmlspecialchars($rec['year_level']) ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    <?php else: ?>
      <p style="text-align: center; color: red;"><?= $error ?? 'No records available.' ?></p>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
