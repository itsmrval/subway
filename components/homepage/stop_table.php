<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Direction</th>
                <th>Next train</th>
                <th>Following departure</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (empty($finalDirections)) {
                echo '<tr><td colspan="3">This train no longer takes passengers</td></tr>';
            }
            foreach ($finalDirections as $direction): 
            ?>
            <tr>
                <td><?php echo htmlspecialchars($direction['direction']); ?></td>
                <td><?php echo htmlspecialchars($direction['next_departure']); ?></td>
                <td><?php echo htmlspecialchars($direction['following_departure']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
