<div>
    <p class="h5"><?php echo $stop_name; ?></p>
    <?php
    $directions = [
        [
            'direction' => 'Château de Vincennes',
            'next_departure' => '05:32',
            'following_departure' => '05:41'
        ],
        [
            'direction' => 'Porte de Pantin',
            'next_departure' => '05:40',
            'following_departure' => '05:49'
        ],
    ];
    include 'stop_table.php';
    ?>
</div>