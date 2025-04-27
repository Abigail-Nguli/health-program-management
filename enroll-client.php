<?php 
    include 'api/config.php';
    include 'menu.php';

    //INITIALIZE VARIABLES
    $client_id = $cilent_name = $client_age = $client_contact = '';

    //GET AND VALIDATE CLIENT ID
    try {
        $client_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$client_id) {
            throw new Exception("Invalid Client ID");
        }

        //GET CLIENT DETAILS
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$client_id]);

        if ($stmt->rowCount() > 0) {
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            $cilent_name = htmlspecialchars($client['name']);
            $cilent_age = htmlspecialchars($client['age']);
            $cilent_contact = htmlspecialchars($client['contact_info']);
        }else {
            throw new Exception("Client not found");
        }
    }catch (Exception $e) {
        echo '<div class="error-message">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        exit();
    }
?>

<div class="form-container">
    <div class="form-card">
        <h1 class="form-title">
            ENROLL CLIENT
        </h1>

        <form action="" method="POST">
            <input type="hidden" name="client_id" value="<?= $client_id ?>">
            <table class="form-table">
                <tr class="form-row">
                    <td class="form-label">Client Name:</td>
                    <td><input type="text" class="form-input disabled-field" value="<?= $cilent_name ?>" readonly></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Age:</td>
                    <td><input type="number" class="form-input disabled-field" value="<?= $cilent_age ?>" readonly></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Contact Info:</td>
                    <td><input type="tel" class="form-input disabled-field" value="<?= $cilent_contact ?>" readonly></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Program</td>
                    <td>
                        <select name="program_id" class="form-input" required>
                            <option value="">Select a program</option>
                            <?php 
                                $stmt = $pdo->prepare("SELECT id, name FROM programs");
                                $stmt->execute();

                                while($program = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="'.htmlspecialchars($program['id']).'">'.htmlspecialchars($program['name']).'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr class="form-row">
                    <td colspan="2"><input type="submit" name="submit" value="Enroll Client" class="submit-btn"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if (isset($_POST['submit'])) {
        try {
            //VALIDATE INPUT
            $client_id = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
            $program_id = filter_input(INPUT_POST, 'program_id', FILTER_VALIDATE_INT);

            

            //CHECK IF ENROLLMENT ALREADY EXISTS
            $stmt = $pdo->prepare("SELECT 1 FROM client_programs WHERE client_id = ? AND program_id = ?");
            $stmt->execute([$client_id, $program_id]);

            if ($stmt->rowCount() > 0) {
                throw new Exception("Client is already enrolled in this program!");
            }

            //ENROLL CLIENT
            $stmt = $pdo->prepare("INSERT INTO client_programs
            (client_id, program_id, enrollment_date)
            VALUES (?, ?, ?)");
            $res = $stmt->execute([$client_id, $program_id, $enrollment_date]);

            if ($res) {
                echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Client Enrolled Successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "index.php"; 
                    }
                  });
            </script>';
            }else {
                throw new Exception("Failed to enroll client");
            }
        }catch(Exception $e) {
            echo '<script>
            Swal.fire({
                title: "Error!",
                text: "'.addslashes($e->getMessage()).'",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
        }
        exit();
    }
?>