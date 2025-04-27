<?php
    include 'api/config.php';

    //VALIDATE ID
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id) {
        die('<!DOCTYPE html>
        <html>
            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">></script>
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Invalid ID",
                            text: "No valid Program ID provided"
                        }).then(() => window.location.href = "<?= SITEURL  ?>");
                    });
                </script>
            </body>
        </html>');
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM programs WHERE id = ?");
        $stmt->execute([$id]);

        echo '<!DOCTYPE html>
        <html>
            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">></script>
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "success",
                            title: "Deleted",
                            text: "Program Deleted Successfully",
                            confirmButtonColor: "#3085d6"
                        }).then((result) => {
                        if(result) {
                         window.location.href = "<?= SITEURL  ?>");
                        }
                    });
                </script>
            </body>
        </html>';
        exit();
    } catch (PDOException $e) {
        echo '<!DOCTYPE html>
        <html>
            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">></script>
            </head>
            <body>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Failed",
                            html: "❌ Failed to Delete Program<br><br>'.addslashes($e->getMessage()).'",
                            confirmButtonColor: "#d33"
                        }).then() => window.location.href = "<?= SITEURL  ?>");
                    });
                </script>
            </body>
        </html>';
        exit();
    }
?>