<?php

function getStops($lineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM stops WHERE lineId = ?");
    $stmt->execute([$lineId]);
    return $stmt->fetchAll();
}

function isFavorite($userId, $stopId, $lineId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM favorites WHERE userId = ? AND stopId = ? AND lineId = ?");
    $stmt->execute([$userId, $stopId, $lineId]);
    return $stmt->rowCount() > 0;
}


?>

<div class="px-4 my-5 text-center">
    <h1 class="display-5 fw-bold">Metro lines</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Explore available Paris metro lines in the IDFM network</p>
      
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <?php 
            for ($i = 1; $i <= 14; $i++): 
                $stops = getStops($i);
                if (!empty($stops)):
            ?>
                <div class="col-2 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <a data-bs-toggle="modal" href="#modal<?= $i ?>">
                                <img src="/assets/lines/<?= $i ?>.svg" alt="Logo Ligne <?= $i ?>" class="img-fluid" style="padding: 10px;">
                            </a>
                            <div class="modal fade" id="modal<?= $i ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Stations de la ligne <?= $i ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <?php 
                                                $stops = getStops($i);
                                                include 'stop_list.php';
                            
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($i % 6 === 0): ?>
                    </div><div class="row">
                <?php endif; ?>
            <?php endif; endfor; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.add-stop, .remove-stop').forEach(function(button) {
        button.addEventListener('click', function() {
            var stopId = this.getAttribute('data-station-id');
            var lineId = this.getAttribute('data-line-id');
            var action = this.classList.contains('add-stop') ? 'add' : 'remove';
            var buttonElement = this;

            fetch('/updateFavorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'stopId=' + stopId + '&lineId=' + lineId + '&action=' + action
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (action === 'add') {
                        buttonElement.classList.remove('add-stop', 'btn-success');
                        buttonElement.classList.add('remove-stop', 'btn-danger');
                        buttonElement.textContent = 'Retirer';
                    } else {
                        buttonElement.classList.remove('remove-stop', 'btn-danger');
                        buttonElement.classList.add('add-stop', 'btn-success');
                        buttonElement.textContent = 'Ajouter';
                    }
                    buttonElement.removeEventListener('click', arguments.callee);
                    buttonElement.addEventListener('click', arguments.callee);
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
