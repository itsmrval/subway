<div class="row">
    <?php
    
    $stations = getStops($i);

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
                        <td><?php echo htmlspecialchars($station['fields']['nom_zda']); ?></td>
                        <td class="text-end"><button class="btn btn-success">Ajouter</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>
