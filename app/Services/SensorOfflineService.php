<?php

namespace App\Services;

use App\Models\SensorOffline;
use DB;

class SensorOfflineService
{

    public function store($queryLog, $id, $uniqueColumn = '')
    {
        $query = $queryLog[0]['query'];
        $bindings = $queryLog[0]['bindings'];

        $i = 0;
        $finalQuery = preg_replace_callback('/\?/', function () use (&$i, $bindings) {
            $value = $bindings[$i++];
            return is_numeric($value) ? $value : "'" . addslashes($value) . "'";
        }, $query);

        // Extract columns from the query
        // preg_match_all('/`(\w+)`/', $query, $matches);
        // $columns = $matches[1];
        // array_shift($columns); // Remove the first element (table name)

        // Generate ON DUPLICATE KEY UPDATE clause
        // $updateClause = [];
        // foreach ($columns as $column) {
        //     if ($column !== $uniqueColumn) { // Exclude unique column
        //         $updateClause[] = "`$column` = VALUES(`$column`)";
        //     }
        // }
        // $finalQuery .= ' ON DUPLICATE KEY UPDATE ' . implode(', ', $updateClause);


        $this->sensorOfflineAction($id, $finalQuery);

    }

    public function update($queryLog, $id)
    {
        $query = $queryLog[0]['query'];
        $bindings = $queryLog[0]['bindings'];


        $i = 0;
        $finalQuery = preg_replace_callback('/\?/', function () use (&$i, $bindings) {
            $value = $bindings[$i++];
            return is_numeric($value) ? $value : "'" . addslashes($value) . "'";
        }, $query);

        $this->sensorOfflineAction($id, $finalQuery);
    }

    public function delete($queryLog, $id)
    {
        $query = $queryLog[0]['query'];
        $bindings = $queryLog[0]['bindings'];


        $i = 0;
        $finalQuery = preg_replace_callback('/\?/', function () use (&$i, $bindings) {
            $value = $bindings[$i++];
            return is_numeric($value) ? $value : "'" . addslashes($value) . "'";
        }, $query);

        $this->sensorOfflineAction($id, $finalQuery);
    }

    public function sensorOfflineAction($id, $finalQuery)
    {
        $sensorOffline = new SensorOffline();

        $sensorOffline->gateway_id = $id;
        $sensorOffline->query = $finalQuery;

        $sensorOffline->save();
    }

}