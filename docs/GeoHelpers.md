### GeoHelpers

Geodesy, geohashes, tiles, spatial SQL snippets, clustering, polylines, and handy geo math.

#### Function Index

- geo_haversine_distance(float $lat1, float $lon1, float $lat2, float $lon2): float
- geo_bbox_for_radius(float $lat, float $lon, float $meters): array
- geo_point_to_hash(float $lat, float $lon, int $precision = 12): string
- geo_hash_to_point(string $geohash): array
- geo_nearest_sql_clause(float $lat, float $lon, int $limit = 10, string $latCol = 'lat', string $lonCol = 'lon'): string
- geo_point_in_polygon(array $point, array $polygon): bool
- geo_polygon_area_sqm(array $polygon): float
- geo_point_to_tile(float $lat, float $lon, int $zoom): array
- geo_tile_to_bbox(int $x, int $y, int $zoom): array
- geo_geohash_prefix_query(string $geohash): array
- geo_build_rtree_index_sql(string $table, string $latCol, string $lonCol): string
- geo_nearest_kdtree(array $points, array $queryPoint, int $k): array
- geo_grid_aggregate_sql(string $latCol, string $lonCol, int $precision): string
- geo_inside_circle_sql(string $latCol, string $lonCol, float $lat, float $lon, float $radiusM): string
- geo_driving_distance_estimate(float $lat1, float $lon1, float $lat2, float $lon2, float $speedKmph = 40): array
- geo_geofence_event_detector(array $point, ?array $previousPoint, array $geofences): array
- geo_cluster_dbscan(array $points, float $epsMeters, int $minPts): array
- geo_encode_polyline(array $points): string
- geo_decode_polyline(string $polyline): array
- geo_s2_cell_covering(float $lat, float $lon, int $level): array
- geo_bbox_overlap_sql(array $boxA, array $boxB, string $latCol = 'lat', string $lonCol = 'lon'): string
- geo_point_grid_index(float $lat, float $lon, int $precision): string
- geo_km_to_degree_lat(float $km): float
- geo_km_to_degree_lon(float $km, float $lat): float
- geo_spherical_centroid(array $points): array
- geo_convex_hull_geo(array $points): array
- geo_snap_to_road_estimate(array $points, array $roadNetworkStub): array
- geo_point_direction_deg(float $lat1, float $lon1, float $lat2, float $lon2): float
- geo_bearing_to_compass(float $bearing): string
- geo_tile_key_hash(float $lat, float $lon, int $zoom): string
- geo_merge_adjacent_geohashes(array $list): array
- geo_polygon_simplify(array $polygon, float $tolerance): array
- geo_spatial_join_sql(string $tableA, string $tableB, string $latA, string $lonA, string $latB, string $lonB, float $radius): string
- geo_time_zone_for_point(float $lat, float $lon): string
- geo_calculate_iso_country(float $lat, float $lon): string
- geo_bounding_circle_from_polygon(array $polygon): array
- geo_point_grid_neighbors(string $gridIndex): array
- geo_heatmap_tiles_for_bbox(array $bbox, int $zoom): array
- geo_equirectangular_distance(float $lat1, float $lon1, float $lat2, float $lon2): float


