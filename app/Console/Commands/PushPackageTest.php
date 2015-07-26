<?php

namespace App\Console\Commands;

use App\Device;
use App\Package;
use App\Push;
use Illuminate\Console\Command;
use JPush\JPushClient;
use JPush\Model as M;

class PushPackageTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:package';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试推送安装包';
    protected $client;

    /**
     * Create a new command instance.
     *
     */
    public function __construct(JPushClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var Package $package
         */
        $package = Package::all()->random();
        $devices = Device::all();
        $installIds = $devices->pluck('push_id')->toArray();
        $this->info('App: '.$package->app_name.'('.$package->apk.')');
        $this->info('Devices: '.$devices->pluck('alias'));
        $this->line('===========================');
        $result = $this->client->push()
            ->setPlatform(M\all)
            ->setAudience(M\registration_id($installIds))
            ->setMessage(M\message($package->toJson(), null, "package"))
            ->send();
        $this->info('Push success');
//        print_r($result->response->body);
//        $msg_ids = $result->msg_id;
//        $report = $this->client->report($msg_ids);
//        print_r($report->received_list);

        $push = new Push();
        $push->package_id = $package->id;
        $push->user_id = 4;
        $push->sendno = $result->sendno;
        $push->msg_id = $result->msg_id;
        $push->is_ok = $result->isOk;
        $push->save();
        print_r($push->toJson());
    }
}
