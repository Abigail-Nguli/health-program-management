<?php 
    include 'db.php';

    $searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

    if (empty($searchTerm)) {
        die('<div class="form-container"><div class="form-card"><div class="error-message">Please enter a search term</div></div></div>');
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE name LIKE ? OR contact_info LIKE ? LIMIT 5");
        $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);

        if ($stmt->rowCount() > 0) {
            while ($client = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $client_id = htmlspecialchars($client['id']);
                $name = htmlspecialchars($client['name']);
                $age = htmlspecialchars($client['age']);
                $gender = htmlspecialchars($client['gender']);
                $contact_info = htmlspecialchars($client['contact_info']);
?>
    <div class="form-container">
        <div class="form-card">
            <?php 
                echo '<div class="search-results-message">Search results for: <strong>"' . htmlspecialchars($searchTerm) . '"</strong></div>';
            ?>

            <h1 class="form-title">CLIENT DETAILS</h1>

            <div class="table-container">
                <!--CLIENT INFO-->
                <table class="form-table">
                    <tr class="form-row">
                        <td class="form-label">Full Name:</td>
                        <td class="form-value"><?= $name ?></td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Age:</td>
                        <td class="form-value"><?= $age ?></td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Gender:</td>
                        <td class="form-value"><?= $gender ?></td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Contact:</td>
                        <td class="form-value"><?= $contact_info ?></td>
                    </tr>
                </table>

            <!--ENROLLED PROGRAMS-->
            <h2 class="programs-title">ENROLLED PROGRAMS: </h2>
            <?php 
                $programStmt = $pdo->prepare("SELECT p.* FROM programs p
                                            JOIN client_programs cp ON p.id = cp.program_id
                                            WHERE cp.client_id = ?");
                $programStmt->execute([$client_id]);

                if ($programStmt->rowCount() > 0) {
                    echo '<table class="programs-table">';
                    echo '<tr class="form-row">
                            <th class="form-label">Program</th>
                            <th class="form-label">Descriptiom</th>
                            <th class="form-label">Duration</th>
                          </tr>';

                    while ($program = $programStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr class="form-row">
                                <td class="form-value">'.htmlspecialchars($program['name']).'</td>
                                <td class="form-value">'.htmlspecialchars($program['description']).'</td>
                                <td class="form-value">'.htmlspecialchars($program['duration']).'</td>
                              </tr>';
                    }
                    echo '</table>';
                }else {
                    echo '<p class="no-programs"No enrolled programs</p>';
                }
            ?>

                <!--ACTION BUTTONS-->
                <div class="action-buttons">
                    <button onclick="window.location.href='client-edit.php?id=<?= $client_id ?>'"
                        class="delete-btn">
                        <i class="fa-solid fa-file-pen"></i> Edit Client
                    </button>
                    <button onclick="confirmDelete('program', <?php echo $id; ?>"
                        class="delete-btn">
                        <i class="fa-solid fa-trash"></i> Delete Client
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
            }
        }else {
            echo '<div class="error-message"No clients found matching <strong>"' . htmlspecialchars($searchTerm) . '"</strong></div>';
        }
    }catch (PDOException $e) {
        echo '<div class="form-container"><div class="form-card"><div class="error-message">Database error: '.htmlspecialchars($e->getMessage()).'</div></div></div>';
    }
?>