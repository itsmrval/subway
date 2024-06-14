<?php 
session_start();

include __DIR__ . '/../../config.php';

$page = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['user_id']) && $page !== 'login.php' && $page !== 'register.php') {
    header("Location: login.php");
    exit();
} else if (isset($_SESSION['user_id']) && ($page === 'login.php' || $page === 'register.php')) {
    header("Location: index.php");
    exit();
}

include 'header.php'; 
include 'navbar.php'; 
include __DIR__ . '/../../services/db.php'; 
    
?>

<main class="container mt-4">
    <?php include $content; ?>
</main>

<?php include 'footer.php'; ?>

<script>
    window.addEventListener('load', function() {
        document.body.style.display = 'block';
    });
</script>

</body>
</html>