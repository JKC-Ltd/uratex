<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SensorLogsExport;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\SensorLog;

class ExportSensorLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:sensor-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports sensor logs to a CSV file and saves it to storage automatically.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $monthsValid = $now->clone()
            ->startOfMonth()
            ->subMonths(3)
            ->addDays(25)
            ->startOfDay()
            ->addHours(9);

        $startDateMonthToExport = $monthsValid->clone()->subDay()->subMonth();
        $endDateMonthToExport = $monthsValid->clone();

        // Define file path
        $fileName = 'exports/sensor_logs_' . now()->format('Y-m-d_His') . '.csv';

        // Export the data and save it in storage
        Excel::store(new SensorLogsExport(), $fileName, 'local');

        // Delete exported logs
        SensorLog::whereBetween('datetime_created', [
            $startDateMonthToExport->toDateTimeString(),
            $endDateMonthToExport->toDateTimeString()
        ])->delete();

        $this->info('Sensor logs exported and deleted successfully!');
    }
}
