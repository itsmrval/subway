<?php

function getStops($line) {
    $json = file_get_contents(__DIR__ . '/../../data/stops.json');
    $data = json_decode($json, true);
    $result = array_filter($data, function($item) use ($line) {
        return $item['fields']['mode'] === 'METRO' && $item['fields']['indice_lig'] === "$line";
    });
    return $result;
}   

?>

<h2>Lignes de Métro</h2>
<div class="row">
    <?php for ($i = 1; $i <= 14; $i++): ?>
        <div class="col-3 mb-3">
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
                                    <?php
                                    include 'components/navigate/stop_list.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>