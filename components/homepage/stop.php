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
        if (strpos($vehicleJourney['OperatorRef']['value'], '.' . $lineId . '.' . $lineId . ':')) {
            if (isset($vehicleJourney['MonitoredCall']['ExpectedDepartureTime'])) {
                $direction = $vehicleJourney['DestinationName'][0]['value'];
                $expectedDeparture = $vehicleJourney['MonitoredCall']['ExpectedDepartureTime'];
                
                $departureTime = date('H:i', strtotime($expectedDeparture . ' +2 hours'));
                $currentTime = date('H:i', strtotime('now' . ' +2 hours'));

                if ($departureTime > $currentTime) {
                    if (!isset($directions[$direction])) {
                        $directions[$direction] = [];
                    }
                    if (count($directions[$direction]) < 2) {
                        $directions[$direction][] = $departureTime;
                    }
                }
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
