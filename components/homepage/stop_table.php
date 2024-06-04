<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Direction</th>
                <th>Prochain départ</th>
                <th>Prochain suivant</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($directions as $direction): ?>
            <tr>
                <td><?php echo $direction['direction']; ?></td>
                <td><?php echo $direction['next_departure']; ?></td>
                <td><?php echo $direction['following_departure']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>