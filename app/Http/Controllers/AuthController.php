<?php

namespace App\Http\Controllers;

use App;
use App\SocialAccount;
use App\User;
use Auth;
use Input;
use Redirect;
use Socialite;
use Validator;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {
	protected $redirectTo = '/';
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * 社交登录
	 */
	public function getSocial() {
		$platform = Input::get('platform');
		if (in_array($platform, SocialAccount::$allowed_platforms)) {
			return Socialite::driver($platform)->redirect();
		}
	}

	/**
	 * 设备
	 */
	public function getDevice() {
		//TODO,检测是否已安装
		return \Redirect::away(env('APP_DOWNLOAD_URL', 'http://fir.im/pushapp'));
	}

	/**
	 * 社交登录回调
	 */
	public function getCallback() {
		$platform = Input::get('platform');

		$info = Socialite::driver($platform)->user();
		$socialAccount = SocialAccount::whereId($info->id)->wherePlatform($platform)->first();
		if (!$socialAccount) {
			$socialAccount = SocialAccount::from($info, $platform);

			if (Auth::guest()) {
				$user = User::create();
				$user->nickname = $socialAccount->nickname;
				$user->avatar = $socialAccount->avatar;
				if ($platform == 'github') {
					$user->email = $socialAccount->email;
				}
			}
			else {
				$user = User::findOrNew(Auth::id());
			}

			$user->social()->save($socialAccount);
			$user->save();
		}
		Auth::loginUsingId($socialAccount->user_id, true);

		return Redirect::to('/');
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::to('/');
	}

	/**
	 * Create a new authentication controller instance.
	 * @param Guard $auth
	 * @param Registrar $registrar
	 */
	public function __construct(Guard $auth, Registrar $registrar) {
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data) {
		return User::create([
			'nickname' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		    'avatar' => url('images/android.png')
		]);
	}
}
