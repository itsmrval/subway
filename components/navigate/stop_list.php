<div class="row">
    <?php
    $stations = array_fill(1, 10, 'Station');
    $half = ceil(count($stations) / 2);
    $chunks = array_chunk($stations, ceil(count($stations) / 2), true);
    ?>

    <?php foreach ($chunks as $chunk): ?>
        <div class="col-md-6">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Station</th>
                    <th class="text-end"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($chunk as $station): ?>
                    <tr>
                        <td><?php echo $station; ?></td>
                        <td class="text-end"><div class="btn btn-success">Ajouter</div></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>