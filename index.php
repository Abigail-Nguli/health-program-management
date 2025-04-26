<?php 
  include 'config.php';
  include 'menu.php';
?>
  <body onload="showSection('health')">
    <div class="container">
      <!--SIDEBAR-->
      <nav class="navbar">
        <ul class="nav-ul">
          <li>
            <button
              id="nav-health"
              class="nav-link"
              onclick="showSection('health')"
              type="button"
            >
              Health Programs
            </button>
          </li>
          <li>
            <button
              id="nav-clients"
              class="nav-link"
              onclick="showSection('clients')"
              type="button"
            >
              Clients
            </button>
          </li>
          <li>
            <button
              id="nav-enroll"
              class="nav-link"
              onclick="showSection('enroll')"
              type="button"
            >
              Enroll Clients
            </button>
          </li>
        </ul>
      </nav>

      <!--MAIN CONTENT AREA-->
      <main class="main-content">
        <!--SEARCH BAR-->
        <div class="search-bar">
          <form
            class="search-form"
            onsubmit="event.preventDefault(); searchClient();"
          >
            <input
              type="text"
              class="search-input"
              id="searchInput"
              placeholder="Search"
              aria-label="Search"
            />
            <button type="submit" class="search-btn" aria-label="Search button">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>

        <!--DYNAMIC CONTENT CONTAINER-->
        <div id="content-container" class="content-container">
          <div id="default-message" class="hidden">
            <!--CONTENT IS INJECTED HERE-->
          </div>
        </div>

        <!--HEALTH PROGRAMS SECTION-->
        <section id="health" class="hidden section-box">
          <button onclick="window.location.href='add-program.php'" type="button" class="add btn">Add New Program</button>
          <table class="custom-table">
            <thead>
              <tr class="custom-row">
                <th class="custom-header">No.</th>
                <th class="custom-header">Program Name</th>
                <th class="custom-header">Description</th>
                <th class="custom-header">Duration</th>
                <th class="custom-header">Actions</th>
              </tr>
            </thead>
            <?php 
              try {
                $stmt = $pdo->prepare("SELECT * FROM programs");
                $stmt->execute();

                $sn = 1;

                if ($stmt->rowCount() > 0) {
                  while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $_rows['id'];
                    $description= $_rows['description'];
                    $name = $_rows['name'];
                    $duration = $_rows['duration'];
            ?>
            <tbody>
              <tr class="custom-row">
                <td class="custom-data"><?php echo $sn ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($name);  ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($description);  ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($duration);  ?></td>
                <td class="custom-data actions-cells">
                  <button class="update btn" onclick="window.location.href='program-edit.php?id=<?php echo $id; ?>'">
                    <i class="fa-solid fa-file-pen"></i>Edit
                  </button>
                  <button class="delete btn" onclick="confirmDelete('program', <?php echo $id; ?>">
                    <i class="fa-solid fa-trash"></i>Delete
                  </button>
                </td>
              </tr>
            </tbody>
            <?php 
                  }
                }else {
                  echo "<tr class='custom-row'><td colspan='12' class='custom-data error'>No Clients Added</td></tr>";
                }
              } catch (PDOException $e) {
                echo '<tr><td colspan="6" class="text-center py-4 text-red-500">Error loading data: '. htmlspecialchars($e->getMessage()) . '</td></tr>';
              }
            ?>
          </table>
        </section>

        <!--CLIENTS SECTION-->
        <section id="clients" class="hidden section-box">
          <button onclick="window.location.href='add-client.php'" type="button" class="add btn">Add New Client</button>
          <table class="custom-table">
            <thead>
              <tr class="custom-row">
                <th class="custom-header">No.</th>
                <th class="custom-header">Full Name</th>
                <th class="custom-header">Age</th>
                <th class="custom-header">Gender</th>
                <th class="custom-header">Contact Info</th>
                <th class="custom-header">Actions</th>
              </tr>
            </thead>
            <?php 
            try {
                  $stmt = $pdo->prepare("SELECT * FROM clients");
                  $stmt->execute();
                  
                  $sn = 1;
                  
                  if($stmt->rowCount() > 0) {
                      while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $rows['id'];
                        $name = $rows['name'];
                        $age = $rows['age'];
                        $gender = $rows['gender'];
                        $contact_info = $rows['contact_info'];
            ?>
            <tbody>
              <tr class="cutom-row">
                <td class="custom-data"><?php echo $sn++; ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($name); ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($age); ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($gender); ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($contact_info); ?></td>
                <td class="custom-data actions-cells">
                  <button class="update btn" onclick="window.location.href='client-edit.php?id=<?php echo $id; ?>'">
                    <i class="fa-solid fa-file-pen"></i>Edit
                  </button>
                  <button class="delete btn" onclick="confirmDelete('client', <?php echo $id; ?>)">
                    <i class="fa-solid fa-trash"></i>Delete
                  </button>
                </td>
              </tr>
              <?php
                        }
                    }
                    else {
                      echo "<tr class='custom-row'><td colspan='12' class='custom-data error'>No Clients Added</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo '<tr><td colspan="6" class="text-center py-4 text-red-500">Error loading data: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                }
              ?>
            </tbody>
          </table>
        </section>

        <!--ENROLL CLIENTS SECTION-->
        <section id="enroll" class="hidden section-box">
          <table class="custom-table">
            <thead>
              <tr class="custom-row">
                <th class="custom-header">No.</th>
                <th class="custom-header">Full Name</th>
                <th class="custom-header">Age</th>
                <th class="custom-header">Gender</th>
                <th class="custom-header">Contact</th>
                <th class="custom-header">Actions</th>
              </tr>
            </thead>
            <?php
            try {
                  $stmt = $pdo->prepare("SELECT * FROM clients");
                  $stmt->execute();
                  
                  $sn = 1;
                  
                  if($stmt->rowCount() > 0) {
                      while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $id = $rows['id'];
                        $name = $rows['name'];
                        $age = $rows['age'];
                        $gender = $rows['gender'];
                        $contact_info = $rows['contact_info'];
            ?>
            <tbody>
              <tr class="custom-row">
                <td class="custom-data"><?php echo $sn++; ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($name); ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($age); ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($gender); ?></td>
                <td class="custom-data"><?php echo htmlspecialchars($contact_info); ?></td>
                <td class="custom-data actions-cells">
                  <button class="update btn" onclick="window.location.href='enroll-client.php?id=<?php echo $id; ?>'">
                    <i class="fa-solid fa-file-pen"></i>ENROLL
                  </button>
                </td>
              </tr>
              <?php
                      }
                    }
                    else {
                      echo "<tr class='custom-row'><td colspan='12' class='custom-data error'>No Clients Added</td></tr>";
                    }
                  } catch (PDOException $e) {
                      echo '<tr><td colspan="6" class="text-center py-4 text-red-500">Error loading data: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                  }
              ?>
            </tbody>
          </table>
        </section>

        <!--SEARCH SECTION-->
        <section id="serach-results" class="hidden section-box">
            <div id="search-results-content">
                <!--REsULTS WILL BE LOADED HERE VIA AJAX-->
            </div>
        </section>
      </main>
    </div>

    <!--FOOTER-->
    <footer>
      <p>
        This project was developed by <b>Abigail Nguli</b> and is open-sourced
        on <a href="">GitHub</a>
      </p>
    </footer>

    <script src="script.js"></script>
  </body>
</html>
