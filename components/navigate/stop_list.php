<div class="row">
    <?php
    $half = ceil(count($stations) / 2);
    $chunks = array_chunk($stations, $half, true);
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
                        <td class="text-end">
                            <?php if (isFavorite($_SESSION['user_id'], $station['fields']['id_ref_zda'], $i)): ?>
                                <button class="btn btn-danger remove-stop" data-station-id="<?= $station['fields']['id_ref_zda'] ?>" data-line-id="<?= $i ?>">Retirer</button>
                            <?php else: ?>
                                <button class="btn btn-success add-stop" data-station-id="<?= $station['fields']['id_ref_zda'] ?>" data-line-id="<?= $i ?>">Ajouter</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>
