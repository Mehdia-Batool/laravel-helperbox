<?php

/**
 * Spatial, Geohash & Geo-SQL Helpers (501–540)
 *
 * Practical, dependency-free geo utilities: distance, bearings, geohash,
 * tiles, simple spatial SQL snippets, grid indexing, clustering, and polylines.
 *
 * @package Subhashladumor\LaravelHelperbox
 */

// Constants
if (!defined('GEO_EARTH_RADIUS_M')) { define('GEO_EARTH_RADIUS_M', 6371000.0); }

// 501
if (!function_exists('geo_haversine_distance')) {
    function geo_haversine_distance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $toRad = fn($d) => $d * M_PI / 180.0;
        $dLat = $toRad($lat2 - $lat1);
        $dLon = $toRad($lon2 - $lon1);
        $a = sin($dLat/2) ** 2 + cos($toRad($lat1)) * cos($toRad($lat2)) * sin($dLon/2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return GEO_EARTH_RADIUS_M * $c;
    }
}

// 502
if (!function_exists('geo_bbox_for_radius')) {
    function geo_bbox_for_radius(float $lat, float $lon, float $meters): array
    {
        $degLat = ($meters / 1000.0) / 111.32; // km per deg lat
        $degLon = ($meters / 1000.0) / (111.32 * max(0.000001, cos($lat * M_PI/180.0)));
        return ['minLat' => $lat - $degLat, 'maxLat' => $lat + $degLat, 'minLon' => $lon - $degLon, 'maxLon' => $lon + $degLon];
    }
}

// Geohash base32
$__geo_base32 = '0123456789bcdefghjkmnpqrstuvwxyz';

// 503
if (!function_exists('geo_point_to_hash')) {
    function geo_point_to_hash(float $lat, float $lon, int $precision = 12): string
    {
        $base32 = '0123456789bcdefghjkmnpqrstuvwxyz';
        $latRange = [-90.0, 90.0];
        $lonRange = [-180.0, 180.0];
        $hash = '';
        $isLon = true; $bit = 0; $ch = 0;
        while (strlen($hash) < $precision) {
            if ($isLon) {
                $mid = ($lonRange[0] + $lonRange[1]) / 2;
                if ($lon >= $mid) { $ch |= 1 << (4 - $bit); $lonRange[0] = $mid; } else { $lonRange[1] = $mid; }
            } else {
                $mid = ($latRange[0] + $latRange[1]) / 2;
                if ($lat >= $mid) { $ch |= 1 << (4 - $bit); $latRange[0] = $mid; } else { $latRange[1] = $mid; }
            }
            $isLon = !$isLon;
            if ($bit === 4) { $hash .= $base32[$ch]; $bit = 0; $ch = 0; }
            else { $bit++; }
        }
        return $hash;
    }
}

// 504
if (!function_exists('geo_hash_to_point')) {
    function geo_hash_to_point(string $geohash): array
    {
        $base32 = '0123456789bcdefghjkmnpqrstuvwxyz';
        $latRange = [-90.0, 90.0];
        $lonRange = [-180.0, 180.0];
        $isLon = true;
        foreach (str_split($geohash) as $c) {
            $val = strpos($base32, $c);
            for ($mask = 16; $mask > 0; $mask >>= 1) {
                if ($isLon) {
                    $mid = ($lonRange[0] + $lonRange[1]) / 2;
                    if ($val & $mask) { $lonRange[0] = $mid; } else { $lonRange[1] = $mid; }
                } else {
                    $mid = ($latRange[0] + $latRange[1]) / 2;
                    if ($val & $mask) { $latRange[0] = $mid; } else { $latRange[1] = $mid; }
                }
                $isLon = !$isLon;
            }
        }
        return ['lat' => ($latRange[0] + $latRange[1]) / 2, 'lon' => ($lonRange[0] + $lonRange[1]) / 2];
    }
}

// 505
if (!function_exists('geo_nearest_sql_clause')) {
    function geo_nearest_sql_clause(float $lat, float $lon, int $limit = 10, string $latCol = 'lat', string $lonCol = 'lon'): string
    {
        // Equirectangular approximation, index-friendly if lat/lon indexed
        $latRad = $lat * M_PI/180.0;
        $sql = "ORDER BY ((($latCol - $lat)*($latCol - $lat)) + ((($lonCol - $lon)*COS($latRad)) * (($lonCol - $lon)*COS($latRad)))) ASC LIMIT $limit";
        return $sql;
    }
}

// 506
if (!function_exists('geo_point_in_polygon')) {
    function geo_point_in_polygon(array $point, array $polygon): bool
    {
        [$x, $y] = [$point[1], $point[0]]; // lon, lat
        $inside = false; $n = count($polygon);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i][1]; $yi = $polygon[$i][0];
            $xj = $polygon[$j][1]; $yj = $polygon[$j][0];
            $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / max(1e-12, ($yj - $yi)) + $xi);
            if ($intersect) $inside = !$inside;
        }
        return $inside;
    }
}

// 507
if (!function_exists('geo_polygon_area_sqm')) {
    function geo_polygon_area_sqm(array $polygon): float
    {
        // Spherical excess approximation via triangulation around centroid
        if (count($polygon) < 3) return 0.0;
        $toRad = fn($d) => $d * M_PI / 180.0;
        $lat0 = array_sum(array_column($polygon, 0)) / count($polygon);
        $lon0 = array_sum(array_column($polygon, 1)) / count($polygon);
        $area = 0.0;
        for ($i = 0; $i < count($polygon); $i++) {
            $j = ($i + 1) % count($polygon);
            $p1 = [$toRad($polygon[$i][0] - $lat0), $toRad(($polygon[$i][1] - $lon0) * cos($toRad($lat0)))];
            $p2 = [$toRad($polygon[$j][0] - $lat0), $toRad(($polygon[$j][1] - $lon0) * cos($toRad($lat0)))];
            $area += ($p1[0] * $p2[1] - $p2[0] * $p1[1]);
        }
        return abs($area) * (GEO_EARTH_RADIUS_M ** 2) / 2.0;
    }
}

// 508
if (!function_exists('geo_point_to_tile')) {
    function geo_point_to_tile(float $lat, float $lon, int $zoom): array
    {
        $latRad = $lat * M_PI/180.0;
        $n = 2 ** $zoom;
        $x = (int) floor(($lon + 180.0) / 360.0 * $n);
        $y = (int) floor((1 - log(tan($latRad) + 1/cos($latRad)) / M_PI) / 2 * $n);
        return ['x' => $x, 'y' => $y];
    }
}

// 509
if (!function_exists('geo_tile_to_bbox')) {
    function geo_tile_to_bbox(int $x, int $y, int $zoom): array
    {
        $n = 2 ** $zoom;
        $lon1 = $x / $n * 360.0 - 180.0;
        $lat1 = rad2deg(atan(sinh(M_PI * (1 - 2 * $y / $n))));
        $lon2 = ($x + 1) / $n * 360.0 - 180.0;
        $lat2 = rad2deg(atan(sinh(M_PI * (1 - 2 * ($y + 1) / $n))));
        return ['minLat' => $lat2, 'minLon' => $lon1, 'maxLat' => $lat1, 'maxLon' => $lon2];
    }
}

// 510
if (!function_exists('geo_geohash_prefix_query')) {
    function geo_geohash_prefix_query(string $geohash): array
    {
        // SQL LIKE patterns for hierarchic prefix search
        $patterns = [];
        for ($i = 1; $i <= strlen($geohash); $i++) { $patterns[] = substr($geohash, 0, $i) . '%'; }
        return $patterns;
    }
}

// 511
if (!function_exists('geo_build_rtree_index_sql')) {
    function geo_build_rtree_index_sql(string $table, string $latCol, string $lonCol): string
    {
        // Vendor differences exist; provide a documentation-friendly suggestion
        return "-- Consider spatial indexes (MySQL: SPATIAL INDEX on POINT(lat,lon) via generated column; SQLite: R*Tree virtual table).\n" .
               "-- Example (MySQL 8+): ALTER TABLE `$table` ADD COLUMN geo POINT GENERATED ALWAYS AS (POINT($lonCol, $latCol)) STORED, ADD SPATIAL INDEX (geo);";
    }
}

// 512 (Simplified: sort by distance; for large N, use true KD-tree)
if (!function_exists('geo_nearest_kdtree')) {
    function geo_nearest_kdtree(array $points, array $queryPoint, int $k): array
    {
        usort($points, function ($a, $b) use ($queryPoint) {
            $da = geo_equirectangular_distance($a[0], $a[1], $queryPoint[0], $queryPoint[1]);
            $db = geo_equirectangular_distance($b[0], $b[1], $queryPoint[0], $queryPoint[1]);
            return $da <=> $db;
        });
        return array_slice($points, 0, max(0, $k));
    }
}

// 513
if (!function_exists('geo_grid_aggregate_sql')) {
    function geo_grid_aggregate_sql(string $latCol, string $lonCol, int $precision): string
    {
        // Group by geohash-like prefix using truncated strings of scaled ints
        $expr = "CONCAT(ROUND($latCol, $precision), ':', ROUND($lonCol, $precision))";
        return "SELECT $expr AS grid, COUNT(*) AS c FROM table GROUP BY grid";
    }
}

// 514
if (!function_exists('geo_inside_circle_sql')) {
    function geo_inside_circle_sql(string $latCol, string $lonCol, float $lat, float $lon, float $radiusM): string
    {
        $bbox = geo_bbox_for_radius($lat, $lon, $radiusM);
        $approx = "$latCol BETWEEN {$bbox['minLat']} AND {$bbox['maxLat']} AND $lonCol BETWEEN {$bbox['minLon']} AND {$bbox['maxLon']}";
        // Add exact Haversine filter (MySQL syntax acceptable as generic snippet)
        $exact = "(6371000*2*ASIN(SQRT( POWER(SIN(RADIANS($lat - $latCol)/2),2) + COS(RADIANS($lat))*COS(RADIANS($latCol))*POWER(SIN(RADIANS($lon - $lonCol)/2),2) ))) <= $radiusM";
        return "($approx) AND $exact";
    }
}

// 515
if (!function_exists('geo_driving_distance_estimate')) {
    function geo_driving_distance_estimate(float $lat1, float $lon1, float $lat2, float $lon2, float $speedKmph = 40): array
    {
        $km = geo_haversine_distance($lat1, $lon1, $lat2, $lon2) / 1000.0;
        // Inflate path by 20% to roughly model roads
        $roadKm = $km * 1.2;
        $minutes = ($roadKm / max(1e-6, $speedKmph)) * 60.0;
        return ['km' => $roadKm, 'minutes' => $minutes];
    }
}

// 516
if (!function_exists('geo_geofence_event_detector')) {
    function geo_geofence_event_detector(array $point, ?array $previousPoint, array $geofences): array
    {
        $events = [];
        foreach ($geofences as $fence) {
            $insideNow = geo_point_in_polygon($point, $fence);
            $insidePrev = $previousPoint ? geo_point_in_polygon($previousPoint, $fence) : false;
            if ($insideNow && !$insidePrev) $events[] = 'enter';
            if (!$insideNow && $insidePrev) $events[] = 'exit';
        }
        return array_values(array_unique($events));
    }
}

// 517 DBSCAN (lat/lon; use equirectangular distance)
if (!function_exists('geo_cluster_dbscan')) {
    function geo_cluster_dbscan(array $points, float $epsMeters, int $minPts): array
    {
        $visited = array_fill(0, count($points), false);
        $clusterId = array_fill(0, count($points), -1);
        $cid = 0;
        for ($i = 0; $i < count($points); $i++) {
            if ($visited[$i]) continue; $visited[$i] = true;
            $neighbors = [];
            for ($j = 0; $j < count($points); $j++) {
                $d = geo_equirectangular_distance($points[$i][0], $points[$i][1], $points[$j][0], $points[$j][1]);
                if ($d <= $epsMeters) $neighbors[] = $j;
            }
            if (count($neighbors) < $minPts) { $clusterId[$i] = -1; continue; }
            $clusterId[$i] = $cid;
            $queue = $neighbors;
            while ($queue) {
                $q = array_pop($queue);
                if (!$visited[$q]) {
                    $visited[$q] = true; $neighbors2 = [];
                    for ($k = 0; $k < count($points); $k++) {
                        $d2 = geo_equirectangular_distance($points[$q][0], $points[$q][1], $points[$k][0], $points[$k][1]);
                        if ($d2 <= $epsMeters) $neighbors2[] = $k;
                    }
                    if (count($neighbors2) >= $minPts) { $queue = array_merge($queue, $neighbors2); }
                }
                if ($clusterId[$q] === -1) $clusterId[$q] = $cid;
            }
            $cid++;
        }
        return $clusterId;
    }
}

// 518
if (!function_exists('geo_encode_polyline')) {
    function geo_encode_polyline(array $points): string
    {
        $result = '';
        $prevLat = 0; $prevLon = 0;
        foreach ($points as $p) {
            $lat = (int) round($p[0] * 1e5);
            $lon = (int) round($p[1] * 1e5);
            $result .= _geo_polyline_encode_value($lat - $prevLat);
            $result .= _geo_polyline_encode_value($lon - $prevLon);
            $prevLat = $lat; $prevLon = $lon;
        }
        return $result;
    }
}

// 519
if (!function_exists('geo_decode_polyline')) {
    function geo_decode_polyline(string $polyline): array
    {
        $index = 0; $lat = 0; $lon = 0; $points = [];
        while ($index < strlen($polyline)) {
            $lat += _geo_polyline_decode_value($polyline, $index);
            $lon += _geo_polyline_decode_value($polyline, $index);
            $points[] = [$lat / 1e5, $lon / 1e5];
        }
        return $points;
    }
}

// 520 (S2-like id: use hashed tile key for a given zoom level)
if (!function_exists('geo_s2_cell_covering')) {
    function geo_s2_cell_covering(float $lat, float $lon, int $level): array
    {
        $tile = geo_point_to_tile($lat, $lon, max(0, min(30, $level)));
        return [hash('crc32b', $tile['x'] . ':' . $tile['y'] . ':' . $level)];
    }
}

// 522
if (!function_exists('geo_bbox_overlap_sql')) {
    function geo_bbox_overlap_sql(array $boxA, array $boxB, string $latCol = 'lat', string $lonCol = 'lon'): string
    {
        return sprintf('(%s BETWEEN %f AND %f AND %s BETWEEN %f AND %f)', $latCol, $boxA['minLat'], $boxA['maxLat'], $lonCol, $boxA['minLon'], $boxA['maxLon']) .
               ' AND ' . sprintf('(%s BETWEEN %f AND %f AND %s BETWEEN %f AND %f)', $latCol, $boxB['minLat'], $boxB['maxLat'], $lonCol, $boxB['minLon'], $boxB['maxLon']);
    }
}

// 523
if (!function_exists('geo_point_grid_index')) {
    function geo_point_grid_index(float $lat, float $lon, int $precision): string
    {
        return sprintf('%.*f:%.*f', $precision, $lat, $precision, $lon);
    }
}

// 524
if (!function_exists('geo_km_to_degree_lat')) {
    function geo_km_to_degree_lat(float $km): float
    {
        return $km / 111.32;
    }
}

// 525
if (!function_exists('geo_km_to_degree_lon')) {
    function geo_km_to_degree_lon(float $km, float $lat): float
    {
        return $km / (111.32 * max(0.000001, cos($lat * M_PI/180.0)));
    }
}

// 526
if (!function_exists('geo_spherical_centroid')) {
    function geo_spherical_centroid(array $points): array
    {
        if (!$points) return ['lat' => 0.0, 'lon' => 0.0];
        $x = $y = $z = 0.0;
        foreach ($points as $p) {
            $lat = $p[0] * M_PI/180.0; $lon = $p[1] * M_PI/180.0;
            $x += cos($lat) * cos($lon);
            $y += cos($lat) * sin($lon);
            $z += sin($lat);
        }
        $total = count($points); $x /= $total; $y /= $total; $z /= $total;
        $lon = atan2($y, $x); $hyp = sqrt($x * $x + $y * $y); $lat = atan2($z, $hyp);
        return ['lat' => $lat * 180.0/M_PI, 'lon' => $lon * 180.0/M_PI];
    }
}

// 527
if (!function_exists('geo_convex_hull_geo')) {
    function geo_convex_hull_geo(array $points): array
    {
        // Use planar Graham scan on lat/lon for simplicity (small areas)
        if (count($points) < 3) return $points;
        usort($points, fn($a,$b) => $a[1] <=> $b[1] ?: $a[0] <=> $b[0]);
        $cross = function($o,$a,$b){return ($a[1]-$o[1])*($b[0]-$o[0])-($a[0]-$o[0])*($b[1]-$o[1]);};
        $lower=[]; foreach($points as $p){ while(count($lower)>=2 && $cross($lower[count($lower)-2],$lower[count($lower)-1],$p)<=0) array_pop($lower); $lower[]=$p; }
        $upper=[]; for($i=count($points)-1;$i>=0;$i--){$p=$points[$i]; while(count($upper)>=2 && $cross($upper[count($upper)-2],$upper[count($upper)-1],$p)<=0) array_pop($upper); $upper[]=$p;}
        array_pop($lower); array_pop($upper); return array_merge($lower,$upper);
    }
}

// 528 (stub: snap to nearest of provided road points)
if (!function_exists('geo_snap_to_road_estimate')) {
    function geo_snap_to_road_estimate(array $points, array $roadNetworkStub): array
    {
        $snapped = [];
        foreach ($points as $p) {
            $minD = PHP_FLOAT_MAX; $best = $p;
            foreach ($roadNetworkStub as $r) {
                $d = geo_equirectangular_distance($p[0], $p[1], $r[0], $r[1]);
                if ($d < $minD) { $minD = $d; $best = $r; }
            }
            $snapped[] = $best;
        }
        return $snapped;
    }
}

// 529
if (!function_exists('geo_point_direction_deg')) {
    function geo_point_direction_deg(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $φ1 = deg2rad($lat1); $φ2 = deg2rad($lat2); $Δλ = deg2rad($lon2 - $lon1);
        $y = sin($Δλ) * cos($φ2);
        $x = cos($φ1)*sin($φ2) - sin($φ1)*cos($φ2)*cos($Δλ);
        $θ = atan2($y, $x);
        $deg = (rad2deg($θ) + 360.0) % 360.0;
        return $deg;
    }
}

// 530
if (!function_exists('geo_bearing_to_compass')) {
    function geo_bearing_to_compass(float $bearing): string
    {
        $dirs = ['N','NNE','NE','ENE','E','ESE','SE','SSE','S','SSW','SW','WSW','W','WNW','NW','NNW'];
        $i = (int) round($bearing / 22.5) % 16;
        return $dirs[$i];
    }
}

// 531
if (!function_exists('geo_tile_key_hash')) {
    function geo_tile_key_hash(float $lat, float $lon, int $zoom): string
    {
        $t = geo_point_to_tile($lat, $lon, $zoom);
        return substr(hash('sha1', $t['x'] . ':' . $t['y'] . ':' . $zoom), 0, 12);
    }
}

// 532 (merge adjacent by prefix truncation)
if (!function_exists('geo_merge_adjacent_geohashes')) {
    function geo_merge_adjacent_geohashes(array $list): array
    {
        sort($list); $merged = [];
        foreach ($list as $h) {
            if (!$merged) { $merged[] = $h; continue; }
            $last = &$merged[count($merged)-1];
            $minLen = min(strlen($last), strlen($h));
            $prefix = '';
            for ($i=0;$i<$minLen;$i++){ if($last[$i]!==$h[$i]) break; $prefix.=$last[$i]; }
            if ($prefix !== '' && strlen($prefix) >= min(strlen($last), strlen($h)) - 1) { $last = $prefix; }
            else { $merged[] = $h; }
        }
        return array_values(array_unique($merged));
    }
}

// 533 Ramer–Douglas–Peucker simplification
if (!function_exists('geo_polygon_simplify')) {
    function geo_polygon_simplify(array $polygon, float $tolerance): array
    {
        if (count($polygon) <= 2) return $polygon;
        $dist = function ($a,$b,$p) {
            // perpendicular distance from p to line ab (approx planar)
            $x1=$a[1];$y1=$a[0];$x2=$b[1];$y2=$b[0];$x0=$p[1];$y0=$p[0];
            $num = abs(($y2-$y1)*$x0-($x2-$x1)*$y0+$x2*$y1-$y2*$x1);
            $den = sqrt((($y2-$y1)**2) + (($x2-$x1)**2));
            return $den ? $num/$den : 0.0;
        };
        $rdp = function ($pts) use (&$rdp,$dist,$tolerance) {
            $maxD = 0; $idx = 0; $end = count($pts)-1;
            for ($i=1;$i<$end;$i++){ $d=$dist($pts[0],$pts[$end],$pts[$i]); if($d>$maxD){$idx=$i;$maxD=$d;} }
            if ($maxD > $tolerance) {
                $res1=$rdp(array_slice($pts,0,$idx+1)); $res2=$rdp(array_slice($pts,$idx));
                return array_merge(array_slice($res1,0,-1), $res2);
            }
            return [$pts[0], $pts[$end]];
        };
        return $rdp($polygon);
    }
}

// 534
if (!function_exists('geo_spatial_join_sql')) {
    function geo_spatial_join_sql(string $tableA, string $tableB, string $latA, string $lonA, string $latB, string $lonB, float $radius): string
    {
        return "SELECT * FROM $tableA a JOIN $tableB b ON (6371000*2*ASIN(SQRT(POWER(SIN(RADIANS(a.$latA)-RADIANS(b.$latB))/2,2)+COS(RADIANS(a.$latA))*COS(RADIANS(b.$latB))*POWER(SIN(RADIANS(a.$lonA)-RADIANS(b.$lonB))/2,2))))) <= $radius";
    }
}

// 535 (stub – requires external DB; return UTC for ocean, else estimate by lon offset)
if (!function_exists('geo_time_zone_for_point')) {
    function geo_time_zone_for_point(float $lat, float $lon): string
    {
        $offset = (int) round($lon / 15.0); // 24 zones
        $sign = $offset >= 0 ? '+' : '-';
        return 'UTC' . ($offset === 0 ? '' : $sign . abs($offset));
    }
}

// 536 (stub – nearest ISO by quadrants)
if (!function_exists('geo_calculate_iso_country')) {
    function geo_calculate_iso_country(float $lat, float $lon): string
    {
        // Heuristic placeholder; real implementation needs dataset
        if ($lat > 0 && $lon > 0) return 'AE';
        if ($lat > 0 && $lon <= 0) return 'CA';
        if ($lat <= 0 && $lon > 0) return 'AU';
        return 'BR';
    }
}

// 537 Approximate minimal bounding circle via centroid radius
if (!function_exists('geo_bounding_circle_from_polygon')) {
    function geo_bounding_circle_from_polygon(array $polygon): array
    {
        if (!$polygon) return ['lat' => 0.0, 'lon' => 0.0, 'radiusM' => 0.0];
        $c = geo_spherical_centroid($polygon); $r = 0.0;
        foreach ($polygon as $p) { $r = max($r, geo_haversine_distance($c['lat'],$c['lon'],$p[0],$p[1])); }
        return ['lat' => $c['lat'], 'lon' => $c['lon'], 'radiusM' => $r];
    }
}

// 538
if (!function_exists('geo_point_grid_neighbors')) {
    function geo_point_grid_neighbors(string $gridIndex): array
    {
        [$latStr, $lonStr] = explode(':', $gridIndex);
        $lat = (float) $latStr; $lon = (float) $lonStr;
        $d = 0.01;
        $neighbors = [];
        foreach ([[0,$d],[0,-$d],[$d,0],[-$d,0],[$d,$d],[$d,-$d],[-$d,$d],[-$d,-$d]] as $off) {
            $neighbors[] = sprintf('%f:%f', $lat + $off[0], $lon + $off[1]);
        }
        return $neighbors;
    }
}

// 539
if (!function_exists('geo_heatmap_tiles_for_bbox')) {
    function geo_heatmap_tiles_for_bbox(array $bbox, int $zoom): array
    {
        $t1 = geo_point_to_tile($bbox['minLat'], $bbox['minLon'], $zoom);
        $t2 = geo_point_to_tile($bbox['maxLat'], $bbox['maxLon'], $zoom);
        $tiles = [];
        for ($x = min($t1['x'],$t2['x']); $x <= max($t1['x'],$t2['x']); $x++) {
            for ($y = min($t2['y'],$t1['y']); $y <= max($t2['y'],$t1['y']); $y++) {
                $tiles[] = ['x' => $x, 'y' => $y, 'z' => $zoom];
            }
        }
        return $tiles;
    }
}

// 540
if (!function_exists('geo_equirectangular_distance')) {
    function geo_equirectangular_distance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $x = deg2rad($lon2 - $lon1) * cos(deg2rad(($lat1 + $lat2)/2));
        $y = deg2rad($lat2 - $lat1);
        return sqrt($x*$x + $y*$y) * GEO_EARTH_RADIUS_M;
    }
}

// Internal helpers
if (!function_exists('_geo_polyline_encode_value')) {
    function _geo_polyline_encode_value(int $value): string
    {
        $value = ($value < 0) ? ~($value << 1) : ($value << 1);
        $out = '';
        while ($value >= 0x20) {
            $out .= chr((0x20 | ($value & 0x1F)) + 63);
            $value >>= 5;
        }
        $out .= chr($value + 63);
        return $out;
    }
}

if (!function_exists('_geo_polyline_decode_value')) {
    function _geo_polyline_decode_value(string $str, int &$index): int
    {
        $result = 0; $shift = 0; $b = 0;
        do { $b = ord($str[$index++]) - 63; $result |= ($b & 0x1F) << $shift; $shift += 5; } while ($b >= 0x20);
        $d = (($result & 1) ? ~($result >> 1) : ($result >> 1));
        return $d;
    }
}

?>


