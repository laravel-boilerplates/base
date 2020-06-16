<?php

    use Carbon\Carbon;

    /**
     * Convert a Carbon object into the local time format.
     *
     * @param  \Carbon\Carbon $carbon
     * @param  string $format
     * @return \Carbon\Carbon
     */
    if (! function_exists('convert_to_localtime')) {
      function convert_to_localtime(Carbon $carbon, $format = 'g:i:s a') {
        return $carbon->setTimezone(session()->get('timezone'))->format($format);
      }
    }

    /**
     * Format bytes to human readable kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  bool    $long
     * @param  integer $precision
     * @return integer
     */
    if (! function_exists('bytes_for_humans')) {
        function bytes_for_humans($size, $long = false, $precision = 2)
        {
            if (abs($size) > 0) {
                $size = abs($size);
                $base = log($size) / log(1024);
                $suffixes = $long ? [' bytes', ' Kilobytes', ' Megabytes', ' Gigabytes', ' Terabytes'] : [' B', ' kB', ' MB', ' GB', ' TB'];

                return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
            } else {
                return $size;
            }
        }
    }
