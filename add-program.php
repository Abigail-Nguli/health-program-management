<?php 
    include 'config.php'; 
    include 'menu.php';
?>

<body>
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">
                ADD PROGRAM
            </h1>

            <form action="" method="POST">
                <table class="form-table">
                    <tr class="form-row">
                        <td class="form-label">Program Name: </td>
                        <td>
                            <input class="form-input" type="text" name="program_name" placeholder="Enter Program Name" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Description</td>
                        <td>
                            <input class="form-input" type="text" name="description" placeholder="Program Description" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Duration</td>
                        <td>
                            <input class="form-input" type="number" name="duration" placeholder="(in days)" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Start Date</td>
                        <td>
                            <input class="form-input" type="date" name="start_date" placeholder="Program Start Date" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Program" class="submit-btn">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
    if (isset($_POST['submit'])) {
        //GET DATA
        $program_name = $_POST['program_name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $start_date = $_POST['start_date'];

        //SQL STATEMENT
        $stmt = $pdo->prepare("INSERT INTO programs (name, description, duration, start_date) VALUES (?, ?, ?, ?)");
        $res = $stmt->execute([$program_name, $description, $duration, $start_date]);

        if ($res) {
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Program Added Successfully!",
                    icon: "success",
                    confirmButonText: "OK
        }).then(() => { window.location.href = "index.php"; });
            </script>';
        }else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "❌Failed to Add Program!",
                    icon: "error",
                    confirmButtonText: "OK
                });
            </script>';
        }
        exit();
    }
?>