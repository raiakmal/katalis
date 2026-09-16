<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Cx;
use Exception;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if($this->data['template'] == "new_updates") {
                Cx::sendEmail(['to' => $this->data['email'], 'data' => [
                    'name' => $this->data['name'],
                    'document_no' => $this->data['document_no'],
                    'status' => $this->data['status'],
                    'notes' => $this->data['notes'],
                ], 'template' => $this->data['template']]);
            }
            else if($this->data['template'] == "new_updates_2") {
                Cx::sendEmail(['to' => $this->data['email'], 'data' => [
                    'name' => $this->data['name'],
                    'document_no' => $this->data['document_no'],
                    'asal_sampel' => $this->data['asal_sampel'],
                    'alamat' => $this->data['alamat'],
                    'nama_sampel' => $this->data['nama_sampel'],
                    'jumlah_sampel' => $this->data['jumlah_sampel'],
                    'jenis_pengujian' => $this->data['jenis_pengujian'],
                    // 'perkiraan' => $this->data['perkiraan'],
                    'status' => $this->data['status'],
                    'notes' => $this->data['notes'],
                ], 'template' => $this->data['template']]);
            }
            else if($this->data['template'] == "new_updates_3") {
                Cx::sendEmail(['to' => $this->data['email'], 'data' => [
                    'name' => $this->data['name'],
                    'document_no' => $this->data['document_no'],
                    'asal_sampel' => $this->data['asal_sampel'],
                    'alamat' => $this->data['alamat'],
                    'nama_sampel' => $this->data['nama_sampel'],
                    'jumlah_sampel' => $this->data['jumlah_sampel'],
                    'jenis_pengujian' => $this->data['jenis_pengujian'],
                    'perkiraan' => $this->data['perkiraan'],
                    'status' => $this->data['status'],
                    'notes' => $this->data['notes'],
                ], 'template' => $this->data['template']]);
            }
            else if ($this->data['template'] == "register_account") {
                Cx::sendEmail(['to' => $this->data['email'], 'data' => [
                    'email' => $this->data['email'],
                    'name' => $this->data['name'],
                    'password' => $this->data['password']
                ], 'template' => $this->data['template']]);
            }
            
        }
        catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
