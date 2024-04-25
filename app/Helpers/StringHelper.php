<?php

class StringHelper
{
    public static function secondsToHuman(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        if ($hours == 0) {
            return sprintf('%02d:%02d', $minutes, $seconds);
        }
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
