<div class="row">
    <?php
    $chunks = array_chunk($stops, ceil(count($stops) / 2), true);
    
    foreach ($chunks as $chunk): ?>
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
                        <td><?php echo htmlspecialchars($station['name']); ?></td>
                        <td class="text-end">
                            <?php if (isFavorite($_SESSION['user_id'], $station['id'], $i)): ?>
                                <button class="btn btn-danger remove-stop" data-station-id="<?= $station['id'] ?>" data-line-id="<?= $i ?>">Revoke</button>
                            <?php else: ?>
                                <button class="btn btn-success add-stop" data-station-id="<?= $station['id'] ?>" data-line-id="<?= $i ?>">Add</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</div>
