<?php include 'config.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Program Client Management</title>
    <script
      src="https://kit.fontawesome.com/a29196e54d.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css" />
</head>
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
                        <td class="form-input">
                            <input type="text" name="program_name" placeholder="Enter Program Name">
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Description</td>
                        <td class="form-input">
                            <input type="text" name="description" placeholder="Program Description">
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Duration</td>
                        <td class="form-input">
                            <input type="number" name="duration" placeholder="(in days)">
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td class="form-label">Start Date</td>
                        <td class="form-input">
                            <input type="date" name="start_date" placeholder="Program Start Date">
                        </td>
                    </tr>
                    <tr class="form-row">
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Program" class="submt-btn">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
    
?>