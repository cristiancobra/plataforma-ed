<?php

namespace App\Http\Controllers\Socialmedia;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Facebook\Facebook;

class FacebookController extends Controller {

	//

	public function index() {
		$user = Auth::user();
		$fb = new \Facebook\Facebook([
			'app_id' => '904299616735303',
			'app_secret' => '989dfd2f25ca0a3f37134e47f99e11c1',
			'default_graph_version' => 'v2.10',
		]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl(route('facebook-callback'), $permissions);

		return view('socialmedia.loginFacebook', [
			'loginUrl' => $loginUrl,
			'user' => $user,
		]);
	}

	public function callback() {
	//	$user = Auth::user();
		$fb = new \Facebook\Facebook([
			'app_id' => '904299616735303',
			'app_secret' => '989dfd2f25ca0a3f37134e47f99e11c1',
			'default_graph_version' => 'v2.10',
		]);

		$helper = $fb->getRedirectLoginHelper();
		try {
			$accessToken = $helper->getAccessToken();
		} catch (Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (isset($accessToken)) {
			// Logged in!
			$_SESSION['facebook_access_token'] = (string) $accessToken;

			// Now you can redirect to another page and use the
			// access token from $_SESSION['facebook_access_token']
		}
	}

	public function getFacebookResources() {

		require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

		$fb = new Facebook\Facebook([
			'app_id' => '904299616735303',
			'app_secret' => '989dfd2f25ca0a3f37134e47f99e11c1',
			'default_graph_version' => 'v2.10',
				//'default_access_token' => '{access-token}', // optional
		]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
		$helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

		try {
			// Get the \Facebook\GraphNodes\GraphUser object for the current user.
			// If you provided a 'default_access_token', the '{access-token}' is optional.
			$accessToken = $helper->getAccessToken();
			$response = $fb->get('/me', $accessToken);
		} catch (\Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (\Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$me = $response->getGraphUser();
		echo 'Logged in as ' . $me->getName();
	}

}
