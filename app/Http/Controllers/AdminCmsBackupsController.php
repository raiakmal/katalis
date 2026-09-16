<?php

namespace App\Http\Controllers;

use DB;
use Cx;
use ZipArchive;

class AdminCmsBackupsController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "program";
        $this->limit = "20";
        $this->orderby = ["created_at" => "desc"];
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = false;
        $this->button_delete = true;
        $this->button_detail = false;
        $this->button_show = false;
        $this->button_filter = false;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "backups";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Tgl. Backup", "name" => "created_at", "callback" => function ($q) {
            return \Carbon\carbon::parse($q->created_at)->translatedFormat("d/M/Y H:i");
        }];


        $this->col[] = ["label" => "Program", "name" => "program", "callback" => function($q){
            $exists = file_exists(storage_path('app/backup/' . $q->program));
            return $exists ? "<i class='fas fa-check-circle text-success'></i>" : "<i class='fas fa-times-circle text-danger'></i>";
        }];
        $this->col[] = ["label" => "DB", "name" => "db", "callback" => function($q){
            $exists = file_exists(storage_path('app/backup/' . $q->db));
            return $exists ? "<i class='fas fa-check-circle text-success'></i>" : "<i class='fas fa-times-circle text-danger'></i>";
        }];

        $this->col[] = ["label" => "Author", "name" => "id_cms_users", "join" => "cms_users,name", "callback_php" => '$row->cms_users_name ?? "Auto"'];

        # END COLUMNS DO NOT REMOVE THIS LINE

        # END FORM DO NOT REMOVE THIS LINE


        $this->index_button = array();
        $this->index_button[] = ['label' => 'Backup Sekarang', 'url' => Cx::mainpath("process"), "icon" => "fa fa-database"];

        $this->addaction = [];
        $this->addaction[] = ["label" => "File", "url" => Cx::mainPath('download-file/[program]'), "icon" => "fas fa-download", "color" => "primary", "showIf" => "([program] <> NULL && [db] <> NULL)", "confirmation" => true];
        $this->addaction[] = ["label" => "DB", "url" => Cx::mainPath('download-file/[db]'), "icon" => "fas fa-download", "color" => "success", "showIf" => "([program] <> NULL && [db] <> NULL)", "confirmation" => true];
    }

    public function getProcess()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);
        $date = now()->format('Y-m-d_His');
        $path = storage_path('app/backup');

        $programFileName = "program-" . $date . ".zip";
        $dbFileName = "db-" . $date . ".sql";

        \File::ensureDirectoryExists($path);

        #App
        $appPath = $path . '/' .  $programFileName;
        $this->Zip(base_path('/'), $appPath);

        #DB
        $dbPath = $path . '/' .  $dbFileName;
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . $dbPath;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);

        DB::table('backups')->insert([
            'program' => $programFileName,
            'db' => $dbFileName,
            'id_cms_users' => Cx::myId() ?? null
        ]);

        if(Cx::myId()) {
            Cx::redirect(Cx::mainPath(), "Proses backup untuk program dan DB sukses dilakukan", "success");
        }
        else {
            return true;
        }
    }

    function Zip($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                } else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    public function getDownloadFile($source)
    {
        $exists = file_exists(storage_path('app/backup/' . $source));
        if($exists) {
            return response()->download(storage_path('app/backup/' . $source));
        }

        Cx::redirect(Cx::mainPath(), "File tidak ditemukan!","warning");
    }

    public function hook_before_delete($id)
    {
        $file = DB::table('backups')->find($id);

        if(file_exists(storage_path('app/backup/' . $file->program))) {
            unlink(storage_path('app/backup/' . $file->program));
        }

        if(file_exists(storage_path('app/backup/' . $file->db))) {
            unlink(storage_path('app/backup/' . $file->db));
        }
    }
}
