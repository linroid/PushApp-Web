<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Package;
use App\Push;
use App\User;
use Auth;
use Exception;
use File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use JPush\JPushClient;
use Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JPush\Model as M;

class PushApk extends Job implements SelfHandling, ShouldQueue {
	use InteractsWithQueue, SerializesModels;
	private $user;
	private $url;
	private $devices;
	private $tmpFile;

	/**
	 * Create a new job instance.
	 * @param User $user
	 */
	public function __construct(User $user, $url, $devices) {
		$this->user = $user;
		$this->url = $url;
		$this->devices = $devices;
	}

	/**
	 * Execute the job.
	 *
	 * @param JPushClient $client
	 */
	public function handle(JPushClient $client) {
		$error = '';
		try {
			if ($this->download($this->url)) {
				$package = Package::createFromFile($this->tmpFile, basename($this->url), $this->user->id);
				$result = Push::send($this->devices, $package, $this->user->id);
				try {
					if ($this->devices->count() > 1) {
						$msg = "已在向{$this->devices->count()}台设备发出推送...";
					}
					else {
						$msg = "已向{$this->devices->first()->alias}发出推送...";
					}
					Log::info($msg);

				} catch (\Exception $e) {
					Log::error('[PushApk Job]推送失败' . $e->getMessage());
					return;
				}
			} else {
				$error = trans('errors.download_failed');
				Log::error('[PushApk Job]下载文件失败: ' . $this->url);
			}
		} catch (Exception $e) {
			$error = $e->getMessage();
			Log::error('[PushApk]' . $e->getMessage() . '  ' . $this->url);
		}
		$installIds = $this->devices->pluck('install_id')->toArray();
		$result = $client->push()
			->setPlatform(M\all)
			->setAudience(M\registration_id($installIds))
			->setNotification(M\notification('出现错误，请检查URL是否正确'))
			->send();

	}

	/**
	 * 下载文件到临时路径
	 * @param $url
	 * @return resource
	 */
	private function download($url) {
		Log::info($this->attempts() . ')downloading: ' . $url);

		$dir = sys_get_temp_dir();

		$path = tempnam($dir, 'apk_');
		$fp = fopen($path, 'w+');
		set_time_limit(0);
		$ch = curl_init(str_replace(" ", "%20", $url));//Here is the file we are downloading, replace spaces with %20
		curl_setopt($ch, CURLOPT_TIMEOUT, 60*5); //10分钟
		curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$success = curl_exec($ch); // get curl response
		curl_close($ch);
		fclose($fp);
		if ($success) {
//			$metaData = stream_get_meta_data($fp);
//			$this->tmpFile = $metaData['uri'];
			$this->tmpFile = $path;
			Log::info('download success: ' . $this->tmpFile);
			return true;
		}
		return false;
	}
}
