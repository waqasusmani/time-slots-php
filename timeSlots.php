<?php


$limits = [
    1 => array("start" => time() + 2000, "end" => time() + 4000),
    2 => array("start" => time() + 6000, "end" => time() + 8000),
    3 => array("start" => time() + 10000, "end" => time() + 12000)
];


$result = GetNextAvailableTimeSlot($limits, time() + 6000, 3000);
print_r($result);

function GetNextAvailableTimeSlot($limits, $start, $length)
{
    $slotStart = 0;
    $slotEnd = 0;
    $slotsAvoided = 0;

    foreach ($limits as $x => $x_value) {
        if (($start + $length) >= $x_value["start"] || ($start + $length) >= $x_value["end"]) {
            $slotsAvoided += ($x_value["end"] - $x_value["start"]);
            echo "Time slot avoided: [" . $x . "]: "  . $x_value["start"] . " to " . $x_value["end"] . "<br>";
        }
    }

    if ($slotsAvoided == 0) {
        $slotStart = $start;
        $slotEnd = $start + $length;
    }

    if ($slotsAvoided > 0) {
        foreach ($limits as $x => $x_value) {
            if ($start >= $x_value["start"] && $start <= $x_value["end"]) {
                $start = $x_value["end"] + 1;
                echo "start fell in time slot " . $x . "<br>";
            }
        }
        echo "start is now : " . $start . "<br>";
        $slotStart= $start;
        $slotEnd = $start + $length;
    } 
    else {
        $slotStart = $start;
        $slotEnd = $start + $length + $slotsAvoided;
    }

    echo "start:" . $slotStart . " & end: " . $slotEnd . "<br>";

    return array("start"=>$slotStart, "end"=>$slotEnd);
}
