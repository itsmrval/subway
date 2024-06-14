<?php

$response = file_get_contents('https://prim.iledefrance-mobilites.fr/marketplace/stop-monitoring?MonitoringRef=STIF:StopArea:SP:' . $stop['stopId'] . ':', 
false, stream_context_create([
    "http" => [
        "header" => "apiKey: " . $idfm_api_key
    ]
]));
$data = json_decode($response, true);

$directions = [];

if (isset($data['Siri']['ServiceDelivery']['StopMonitoringDelivery'][0]['MonitoredStopVisit'])) {
    foreach ($data['Siri']['ServiceDelivery']['StopMonitoringDelivery'][0]['MonitoredStopVisit'] as $visit) {
        $vehicleJourney = $visit['MonitoredVehicleJourney'];
        if (isset($vehicleJourney['MonitoredCall']['ExpectedArrivalTime'])) {
            $direction = $vehicleJourney['DirectionName'][0]['value'];
            $expectedArrival = $vehicleJourney['MonitoredCall']['ExpectedArrivalTime'];
            $expectedDeparture = $vehicleJourney['MonitoredCall']['ExpectedDepartureTime'];
            
            $departureTime = date('H:i', strtotime($expectedArrival . ' +2 hours'));

            if (!isset($directions[$direction])) {
                $directions[$direction] = [];
            }
            if (count($directions[$direction]) < 2) {
                $directions[$direction][] = $departureTime;
            }
        }
    }
}

$finalDirections = [];
foreach ($directions as $direction => $times) {
    if (count($times) == 2) {
        $finalDirections[] = [
            'direction' => $direction,
            'next_departure' => $times[0],
            'following_departure' => $times[1]
        ];
    } elseif (count($times) == 1) {
        $finalDirections[] = [
            'direction' => $direction,
            'next_departure' => $times[0],
            'following_departure' => '-'
        ];
    }
}

?>

<div>
    <p class="h5 d-inline"><?php echo $stop_name; ?></p>
    <a id="remove-<?php echo $stop['stopId'] . "-" . $lineId ?>" class="btn btn-danger btn-sm mb-2" onclick="removeFavorite(<?php echo $stop['stopId'] . ',' . $lineId; ?>)"><i class="fa fa-trash"></i></a>
</div>

<?php include 'stop_table.php'; ?>
