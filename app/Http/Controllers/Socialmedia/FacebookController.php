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
		session_start();
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
		$user = Auth::user();
		session_start();
		$fb = new \Facebook\Facebook([
			'app_id' => '904299616735303',
			'app_secret' => '989dfd2f25ca0a3f37134e47f99e11c1',
			'default_graph_version' => 'v2.10',
		]);

		$helper = $fb->getRedirectLoginHelper();

		try {
			$accessToken = $helper->getAccessToken();
		} catch (Facebook\Exception\ResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch (Facebook\Exception\SDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (!isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}

// Logged in
	//	echo '<h3>Access Token</h3>';
	//	var_dump($accessToken->getValue());
		echo '<h3>Seu token de acesso é'.$accessToken.'</h3>';

// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
		$tokenMetadata = $oAuth2Client->debugToken($accessToken);
	//	echo '<h3>Metadata</h3>';
	//	var_dump($tokenMetadata);
		echo '<h3>Seu token de acesso é'.$tokenMetadata.'</h3>';

// Validation (these will throw FacebookSDKException's when they fail)
//		$tokenMetadata->validateAppId($config['app_id']);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
		$tokenMetadata->validateExpiration();

		if (!$accessToken->isLongLived()) {
			// Exchanges a short-lived access token for a long-lived one
			try {
				$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			} catch (Facebook\Exception\SDKException $e) {
				echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
				exit;
			}

			echo '<h3>Long-lived</h3>';
			var_dump($accessToken->getValue());
		}

		$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');

		return view('socialmedia.fb-callback', [
			'accessToken' => $accessToken,
			'user' => $user,
		]);
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
