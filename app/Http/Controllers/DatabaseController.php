<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatabaseController extends Controller
{
    public function download()
    {
        try {
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME', 'root');
            $dbPassword = env('DB_PASSWORD', '');

            // $dbHost = env('DB_HOST');
            // $dbPort = env('DB_PORT');
            // $dbName = env('DB_DATABASE');
            // $dbUser = env('DB_USERNAME');
            // $dbPassword = env('DB_PASSWORD');
            
            $backupFile = storage_path('app/backup/database_backup.sql');

            if (!file_exists(storage_path('app/backup'))) {
                mkdir(storage_path('app/backup'), 0755, true);
            }

            $dumpCommand = "mysqldump -h $dbHost -P $dbPort -u $dbUser --password=$dbPassword $dbName > $backupFile";
            exec($dumpCommand);

            if (!file_exists($backupFile)) {
                return response()->json(['message' => 'Database backup failed'], 500);
            }

            $response = new StreamedResponse(function () use ($backupFile) {
                $stream = fopen($backupFile, 'r');
                fpassthru($stream);
                fclose($stream);
            });

            $response->headers->set('Content-Type', 'application/octet-stream');
            $response->headers->set('Content-Disposition', 'attachment; filename="database_backup.sql"');

            DB::statement('DROP DATABASE `' . $dbName . '`');
            DB::statement('CREATE DATABASE `' . $dbName . '`');

            unlink($backupFile);

            return $response;

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
