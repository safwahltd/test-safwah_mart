<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\DbDumper\Databases\MySql;

class DatabaseBackupController extends Controller
{
    public function db_backup(Request $request)
    {
        // $host       = env('DB_HOST');
        // $username   = env('DB_USERNAME');
        // $password   = env('DB_PASSWORD');
        // $database   = env('DB_DATABASE');
        $ds         = DIRECTORY_SEPARATOR;


        $path       = public_path() . $ds . 'app' . $ds . 'backups' . $ds;
        $file       = 'dump.sql';
        $directory  = $path . $file;
        $filename   = 'backup_' . fdate(now(), 'Y_m_d_h_i_s') . '.sql';
        // $command    = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username, $password, $database, $path . $file);

        // Storage::disk('google')->put('HomeController.php', 'Hello World');
        // return $contents = collect(Storage::cloud()->listContents('/', false));
        // return 'success';

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        // exec($command);

        // return response()->download($directory, $filename);

        // dd($command);
        // dd(4555);

        // $this->backupSavedToGoogleDrive($filename, $directory);


        // // backup send to email
        // $this->sendDatabaseToEmail($filename, $directory);

        // $date = date('Y-m-d');
        // $date = '2020-12-20';

        // Storage::cloud()->put(public_path('app/backups/dump.text'), $filename);
        // return 'success';
        MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->setHost(env('DB_HOST'))
            ->setPort(env('DB_PORT'))
            ->doNotCreateTables()
            ->dumpToFile($directory);


        
        // return response()->download($path . 'nothing.txt', $filename);
        // $this->backupSavedToGoogleDrive($filename, $path . 'nothing.txt');

        // return 'success';
        // download to local
        return response()->download($directory, $filename);
        return redirect()->back()->with('message', 'Database Backup Complete');
    }
}
