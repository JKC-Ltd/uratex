<?php

namespace App\Exports;

use App\Models\SensorLog;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SensorLogsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $now = Carbon::now();

        $monthsValid = $now
            ->clone()
            ->startOfMonth()
            ->subMonths(3)
            ->addDays(25)
            ->startOfDay()
            ->addHours(9);

        $startDateMonthToExport = $monthsValid->clone()->subDay()->subMonth();
        $endDateMonthToExport = $monthsValid->clone();

        return SensorLog::whereBetween('datetime_created', [
            $startDateMonthToExport->toDateTimeString(),
            $endDateMonthToExport->toDateTimeString()
        ])
            ->select(
                'sensor_logs.id',
                'sensors.description AS sensor_name',
                'gateways.description AS gateway_name',
                'sensor_logs.voltage_ab',
                'sensor_logs.voltage_bc',
                'sensor_logs.voltage_ca',
                'sensor_logs.current_a',
                'sensor_logs.current_b',
                'sensor_logs.current_c',
                'sensor_logs.real_power',
                'sensor_logs.apparent_power',
                'sensor_logs.energy',
                'sensor_logs.temperature',
                'sensor_logs.humidity',
                'sensor_logs.volume',
                'sensor_logs.flow',
                'sensor_logs.pressure',
                'sensor_logs.co2',
                'sensor_logs.pm25_pm10',
                'sensor_logs.o2',
                'sensor_logs.nox',
                'sensor_logs.co',
                'sensor_logs.s02',
                'sensor_logs.datetime_created'
            )
            ->leftJoin('sensors', 'sensors.id', '=', 'sensor_logs.sensor_id')
            ->leftJoin('gateways', 'gateways.id', '=', 'sensor_logs.gateway_id')
            ->orderBy('datetime_created')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Sensor',
            'Gateway',
            'Votage AB',
            'Votage BC',
            'Votage CA',
            'Current A',
            'Current B',
            'Current C',
            'Real Power',
            'Apparent Power',
            'Energy',
            'Temperature',
            'Humidity',
            'Volume',
            'Flow',
            'Pressure',
            'CO2',
            'PM2.5/PM10',
            'O2',
            'NOx',
            'CO',
            'S02',
            'Datetime Created'
        ];
    }
}
