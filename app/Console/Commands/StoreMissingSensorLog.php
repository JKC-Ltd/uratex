<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use App\Models\SensorLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StoreMissingSensorLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-missing-sensor-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Storing missing sensor logs in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Storing missing sensor logs in the database...');

        // Logic to store missing sensor logs
        // This is a placeholder. You should implement the actual logic here.

        $interval5Mins = Carbon::now()->subMinutes(5); // Subtract 5 minutes from now
        $roundedTime = $interval5Mins->startOfMinute()->minute - ($interval5Mins->minute % 5); // Round down to nearest 5 mins
        $interval5Mins->minute($roundedTime); // Set the new minute value

        $endInterval = $interval5Mins->clone()->addMinutes(4); // Add 4 minutes to the interval

        // dd($interval5Mins->toDateTimeString());

        $sensors = Sensor::all();

        foreach ($sensors as $key => $sensor) {
            $sensor_logs = SensorLog::where('sensor_id', $sensor->id)
                ->whereBetween('datetime_created', [
                    $interval5Mins->toDateTimeString(),
                    $endInterval->toDateTimeString()
                ])
                ->orderBy('datetime_created', 'desc')
                ->get();

            if ($sensor_logs->isEmpty()) {
                $sensor_log = new SensorLog;

                $sensor_log->sensor_id = $sensor->id;
                $sensor_log->gateway_id = $sensor->gateway_id;
                $sensor_log->voltage_ab = 0;
                $sensor_log->voltage_bc = 0;
                $sensor_log->voltage_ca = 0;
                $sensor_log->current_a = 0;
                $sensor_log->current_b = 0;
                $sensor_log->current_c = 0;
                $sensor_log->real_power = 0;
                $sensor_log->apparent_power = 0;
                $sensor_log->energy = 0;
                $sensor_log->temperature = 0;
                $sensor_log->humidity = 0;
                $sensor_log->volume = 0;
                $sensor_log->flow = 0;
                $sensor_log->pressure = 0;
                $sensor_log->co2 = 0;
                $sensor_log->pm25_pm10 = 0;
                $sensor_log->o2 = 0;
                $sensor_log->nox = 0;
                $sensor_log->co = 0;
                $sensor_log->s02 = 0;
                $sensor_log->datetime_created = $interval5Mins->toDateTimeString();

                $sensor_log->save();

                $this->line("Missing sensor logs stored successfully!, Sensor ID: {$sensor->id}");
            }
        }

        $this->info('Storing missing sensor logs in the database finished.');
    }
}
