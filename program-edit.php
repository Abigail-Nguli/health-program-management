<?php 
    include 'api/config.php';
    include 'menu.php';

    //INITIALIZE VARIABLES
    $id = $name = $description = $duration ='';

    //GET AND VALIDATE PROGRAM ID
    try {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            throw new Exception("Invalid Program ID");
        }

        //DATABASE QUERY
        $stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            $client = $stmt->fetch(PDO::FETCH_ASSOC);
            $name = htmlspecialchars($client['name']);
            $description = htmlspecialchars($client['description']);
            $duration = htmlspecialchars($client['duration']);
        }else {
            throw new Exception("Program Not Found");
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
            EDIT Program
        </h1>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <table class="form-table">
                <tr class="form-row">
                    <td class="form-label">Client Name:</td>
                    <td><input type="text" name="name" value="<?= $name ?>" class="form-input"></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Description:</td>
                    <td><input type="text" name="description" value="<?= $description ?>" class="form-input"></td>
                </tr>
                <tr class="form-row">
                    <td class="form-label">Duration:</td>
                    <td><input type="tel" name="duration" value="<?= $duration ?>" class="form-input"></td>
                </tr>
                <tr class="form-row">
                    <td colspan="2">
                        <input type="submit" name="submit" value="Update Program" class="submit-btn">
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
            $description = trim($_POST['description']);
            $duration = filter_input(INPUT_POST, 'duration', FILTER_VALIDATE_INT);

            if(!$id || empty($name)) {
                throw new Exception("Invalid input data");
            }

            //UPDATE CLIENT
            $stmt = $pdo->prepare("UPDATE programs SET name = ?, description = ?, duration = ? WHERE id = ?");
            $res = $stmt->execute([$name, $description, $duration, $id]);

            if ($res && $stmt->rowCount() > 0) {
                echo '<script>
                        Swal.fire({
                            title: "Success!",
                            text: "Program Updated Successfully!",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result).isConfirmed {
                                window.location.href = "index.php"; }); 
                            }
                         });
                    </script>';
            }else {
                throw new Exception("No Changes made or Program Not Found");
            }
        } catch (Exception $e) {
            echo '<script>
                        Swal.fire({
                            title: "Error!",
                            text: "'.addslashes($e->getMessage()).'",
                            icon: "error",
                            confirmButtonText: "OK"
                        }).then(() => { window.location.href = "index.php"; });
                    </script>';
        }
        exit();
    }
?>