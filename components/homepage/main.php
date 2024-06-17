<?php

function getStopName($stopId) {
    $json = file_get_contents(__DIR__ . '/../../data/stops.json');
    $result = array_filter(json_decode($json, true), function($item) use ($stopId) {
        return $item['fields']['mode'] === 'METRO' && $item['fields']['id_ref_zda'] === $stopId;
    });
        
    return reset($result)['fields']['nom_zda'];
}

function getFavorites($lineId) {
    global $conn;
    try {
        $query = $conn->prepare("SELECT stopId FROM favorites WHERE lineId = ?");
        $query->execute([$lineId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    } catch(PDOException $e) {
        return [];
    }
}

$query = $conn->prepare("SELECT DISTINCT lineId FROM favorites WHERE userId = ?");
$query->execute([$_SESSION['user_id']]);
$lineIds = $query->fetchAll(PDO::FETCH_COLUMN);

echo $_SERVER['REMOTE_ADDR'];

?>

<div class="px-4 my-5 text-center">
    <h1 class="display-5 fw-bold">Subways</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Displaying your favorite stations and lines below</p>
      
    </div>
</div>

<?php
foreach ($lineIds as $lineId) {
    include 'line.php';
}

if (empty($lineIds)) {
    echo '<div class="alert alert-info text-center" role="alert">You havent added any favorites yet.</div>';
}
?>

<script>
function removeFavorite(stopId, lineId) {

    var formData = new FormData();
    formData.append('stopId', stopId);
    formData.append('lineId', lineId);
    formData.append('action', 'remove');

    fetch('/updateFavorite.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.log(error);
    });
}
</script>
