<?php

namespace App\Services;

use App\Models\SensorOffline;
use DB;

class EnergyConsumptionService
{

    public function get($request)
    {
        $sensor_logs = DB::table('sensor_logs')
            ->selectRaw("
                sensor_id,
                DATE(datetime_created - INTERVAL 7 HOUR) AS reading_date,
                MIN(energy) AS start_energy,
                MAX(energy) AS end_energy,
                real_power,
                datetime_created
            ");

        if ($request->startDate && $request->endDate) {
            // This should be dynamic based on the request parameters.
            $sensor_logs->where("datetime_created", ">=", $request->startDate)
                ->where("datetime_created", "<=", $request->endDate);
        }


        $sensor_logs->groupBy('sensor_id', 'reading_date');

        $query = DB::table(DB::raw("({$sensor_logs->toSql()}) as daily_energy"))
            ->mergeBindings($sensor_logs)
            ->selectRaw("
                {$request->select}
            ");

        $query->leftJoin('sensors', 'sensor_id', '=', 'sensors.id')
            ->leftJoin('locations', 'location_id', '=', 'locations.id')
            ->orderBy('sensor_id')
            ->orderBy('reading_date');

        if ($request->where) {
            foreach ($request->where as $where) {
                $query->where($where['field'], $where['operator'], $where['value']);
            }
        }

        if ($request->whereIn) {
            foreach ($request->whereIn as $whereIn) {
                $query->whereIn($whereIn['field'], $whereIn['value']);
            }
        }

        if ($request->groupBy) {
            $query->groupBy($request->groupBy);
        }

        return $query;

    }

    public function getPerBuilding($request)
    {
        // Expecting an array of root location ids in $request->roots OR
        // a whereIn clause with field 'location_id' (backwards compatibility).
        $roots = [];
        if (!empty($request->roots) && is_array($request->roots)) {
            $roots = array_map('intval', $request->roots);
        } elseif (!empty($request->whereIn) && is_array($request->whereIn)) {
            // look for a location_id whereIn
            foreach ($request->whereIn as $whereIn) {
                if (($whereIn['field'] ?? '') === 'location_id' && is_array($whereIn['value'])) {
                    $roots = array_map('intval', $whereIn['value']);
                }
            }
        }

        if (empty($roots)) {
            // nothing to aggregate
            return [];
        }

        // Bindings for start/end date if provided
        $bindings = [];
        $dateFilter = '';
        if (!empty($request->startDate) && !empty($request->endDate)) {
            $dateFilter = 'WHERE datetime_created >= ? AND datetime_created <= ?';
            $bindings[] = $request->startDate;
            $bindings[] = $request->endDate;
        }

        // Root ids list for SQL
        $rootList = implode(',', array_map('intval', $roots));

        // Build recursive CTE to map every location to its root (6/7/8 etc.)
        $sql = "WITH RECURSIVE locs AS (
            SELECT id, pid, id AS root_id FROM locations WHERE id IN ($rootList)
            UNION ALL
            SELECT l.id, l.pid, locs.root_id
            FROM locations l
            JOIN locs ON l.pid = locs.id
        ), daily AS (
            SELECT
                sensor_id,
                DATE(datetime_created - INTERVAL 7 HOUR) AS reading_date,
                MIN(energy) AS start_energy,
                MAX(energy) AS end_energy,
                MAX(datetime_created) AS datetime_created
            FROM sensor_logs
            $dateFilter
            GROUP BY sensor_id, DATE(datetime_created - INTERVAL 7 HOUR)
        )
        SELECT
            locs.root_id AS root_location_id,
            root.location_name AS root_location_name,
            daily.reading_date,
            ROUND(SUM(daily.end_energy - daily.start_energy), 2) AS daily_consumption
        FROM daily
        JOIN sensors s ON daily.sensor_id = s.id
        JOIN locations loc ON s.location_id = loc.id
        JOIN locs ON loc.id = locs.id
        JOIN locations root ON locs.root_id = root.id
        GROUP BY locs.root_id, root.location_name, daily.reading_date
        ORDER BY locs.root_id, daily.reading_date";

        $results = DB::select($sql, $bindings);

        return $results;
    }

    public function getPower($request)
    {

        $sensor_logs = DB::table('sensor_logs')
            ->selectRaw("
                sensor_id,
                DATE_FORMAT(datetime_created, '%Y-%m-%d %H:%i') AS datetime_created,
                voltage_ab,
                voltage_bc,
                voltage_ca,
                current_a,
                current_b,
                current_c,
                real_power,
                apparent_power
            ");

        if ($request->startDate && $request->endDate) {
            // This should be dynamic based on the request parameters.
            $sensor_logs->where("datetime_created", ">=", $request->startDate)
                ->where("datetime_created", "<=", $request->endDate);
        }

        $query = DB::table(DB::raw("({$sensor_logs->toSql()}) as daily_energy"))
            ->mergeBindings($sensor_logs)
            ->selectRaw("
                {$request->select}
            ");

        if ($request->where) {
            $query->where($request->where['field'], $request->where['operator'], $request->where['value']);
        }

        $query->leftJoin('sensors', 'sensor_id', '=', 'sensors.id')
            ->leftJoin('sensor_models', 'sensor_model_id', '=', 'sensor_models.id')
            ->orderBy('sensor_id')
            ->orderBy('datetime_created');

        if ($request->groupBy) {
            $query->groupBy($request->groupBy);
        }

        return $query;

    }

}