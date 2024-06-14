<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <img src="/assets/lines/m.svg" width="64px" class="img-fluid mb-3">&nbsp;&nbsp;
            <img src="/assets/lines/<?php echo $lineId; ?>.svg" width="64px" class="img-fluid mb-3">
        </div>

        <?php
        $favoriteStops = getFavorites($lineId);
    
        foreach ($favoriteStops as $stop) {
            $stop_name = getStopName($stop['stopId']);
            include 'stop.php';
            if (count($favoriteStops) > 1) {
                echo '<hr class="mt-4">';
            }
        }
        ?>
    </div>
</div>
