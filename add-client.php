<?php 
    include 'api/config.php'; 
    include 'menu.php';
?>

<body>
    <div class="form-container">
        <div class="form-card">
            <h1 class="form-title">
                ADD CLIENT
            </h1>

            <form action="" method="POST">
                <table class="form-table">
                    <tr class="form-row">
                        <td class="form-label">Full Name: </td>
                        <td>
                            <input class="form-input" type="text" name="name" placeholder="Enter your Full Name" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Age</td>
                        <td>
                            <input class="form-input"  type="text" name="age" placeholder="Enter your Age" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Gender</td>
                        <td>
                            <select name="gender" required>
                                <option value="" disabled selected>Select your gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Contact</td>
                        <td>
                            <input class="form-input" type="tel" name="contact_info" placeholder="+254 xxx" required>
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Client" class="submit-btn">
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
        $name = $_POST['name'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $contact_info = $_POST['contact_info'];

        //SQL STATEMENT
        $stmt = $pdo->prepare("INSERT INTO clients (name, age, gender, contact_info) VALUES (?, ?, ?, ?)");
        $res = $stmt->execute([$name, $age, $gender, $contact_info]);

        if ($res) {
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Client Added Successfully!",
                    icon: "success",
                    confirmButonText: "OK"
        }).then((result) => {
            if (result).isConfirmed {
                 window.location.href = "<?= SITEURL ?>";  
            }
        });
        </script>';
        }else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "❌Failed to Add Client!",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }
        exit();
    }
?>