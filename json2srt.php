<?php
    function float_to_time_string($float_time) : string {
        $hours = floor($float_time / 3600);
        $minutes = floor(($float_time / 60) % 60);
        $seconds = floor($float_time % 60);
        $milliseconds = round(($float_time - floor($float_time)) * 1000);
    
        return sprintf("%02d:%02d:%02d,%03d", $hours, $minutes, $seconds, $milliseconds);
    }

    function mstime_to_srttime(float $start, float $end) : string {
        $start_time_string = float_to_time_string($start);
        $end_time_string = float_to_time_string($end);
        
        return "$start_time_string --> $end_time_string";
    }
    
    if($argc < 2) {
        echo "No file provided\n";
        exit(0);
    }

    $filename = $argv[1];
    $file = file_get_contents($filename);
    $json = json_decode($file);
    $output = "";
    
    $rlen = count($json->results);
    for($i = 0; $i < $rlen; $i++) {
        $sub = $json->results[$i]->alternatives[0];
        $text = $sub->transcript;
        $time_start = $sub->timestamps[0][1];
        $time_end = $sub->timestamps[count($sub->timestamps)-1][2];

        $index = $i + 1;
        $timestr = mstime_to_srttime($time_start, $time_end);
        $output .= "$index\n$timestr\n$text\n\n";
    }

    file_put_contents("$filename.srt", $output);
    echo "Done, output written to $filename.srt\n";
