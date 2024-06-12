<?php 
session_start();

include 'config.php';

$page = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['user_id']) && $page !== 'login.php' && $page !== 'register.php') {
    header("Location: login.php");
    exit();
} else if (isset($_SESSION['user_id']) && ($page === 'login.php' || $page === 'register.php')) {
    header("Location: index.php");
    exit();
}

include 'structure/header.php'; 
include 'structure/navbar.php'; 
include 'services/db.php'; 
    
?>

<main class="container mt-4">
    <?php include $content; ?>
</main>

<?php include 'structure/footer.php'; ?>

<script>
    window.addEventListener('load', function() {
        document.body.style.display = 'block';
    });
</script>

</body>
</html>