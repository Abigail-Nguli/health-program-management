<?php 
    include 'api/config.php';
    include 'menu.php';

    //INITIALIZE VARIABLES
    $id = $name = $name = $contact_info = '';

    //GET AND VALIDATE CLIENT ID
    try {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            throw new Exception("Invalid Client ID");
        }

        //DATABASE QUERY
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            $name = htmlspecialchars($client['name']);
            $age = htmlspecialchars($client['age']);
            $contact_info = htmlspecialchars($client['contact_info']);
        }else {
            throw new Exception("Client Not Found");
        }
    }
    catch (Exception $e) {
        echo 'div class="error-message">Error: ' .htmlspecialchars($e->getMessage()) . '</div>';
        exit();
    }
?>

<div class="form-container">
    <div class="form-card">
        <h1 class="form-title">
            EDIT CLIENT
        </h1>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <table class="form-table">
                <tr class="form-row">
                    <td class="form-label">Client Name:</td>
                    <td><input type="text" name="name" value="<?= $name ?>" class="form-input"></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Age:</td>
                    <td><input type="number" name="age" value="<?= $age ?>" class="form-input"></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Countact:</td>
                    <td><input type="tel" name="contact_info" value="<?= $contact_info ?>" class="form-input"></td>
                </tr>
                <tr class="form-row">
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Client" class="submit-btn">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if (isset($_POST['submit'])) {
        try {
            //VALIDATE INPUT
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $name = trim($_POST['name']);
            $age = trim($_POST['age']);
            $contact_info = filter_input(INPUT_POST, 'contact_info', FILTER_VALIDATE_INT);

            if(!$id || empty($name)) {
                throw new Exception("Invalid input data");
            }

            //UPDATE CLIENT
            $stmt = $pdo->prepare("UPDATE clients SET name = ?, age = ?, contact_info = ? WHERE id = ?");
            $res = $stmt->execute([$name, $age, $contact_info, $id]);

            if ($res && $stmt->rowCount() > 0) {
                echo '<script>
                        Swal.fire({
                            title: "Success!",
                            text: "Client Updated Successfully!",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result).isConfirmed {
                                window.location.href = "<?= SITEURL ?>";
                            }
                         });
                    </script>';
            }else {
                throw new Exception("No Changes made or Client Not Found");
            }
        } catch (Exception $e) {
            echo '<script>
                        Swal.fire({
                            title: "Error!",
                            text: "'.addslashes($e->getMessage()).'",
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(() => { window.location.href = "<?= SITEURL ?>"; });
                    </script>';
        }
        exit();
    }
?>