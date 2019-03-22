<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginflow extends CI_Controller {

		public function __construct()
		{
			parent::__construct();
			
			// $this->load->add_package_path('/Users/elliot/github/codeigniter-facebook/application/');
			$this->load->library('facebook');
			$this->facebook->enable_debug(TRUE);
		}
		
		public function index()
		{
			// We can use the open graph place meta data in the head.
			// This meta data will be used to create a facebook page automatically
			// when we 'like' the page.
			// 
			// For more details see: http://developers.facebook.com/docs/opengraph
			

			$this->load->view('facebook_view');
		}
		
		public function login()
		{
			// This is the easiest way to keep your code up-to-date. Use git to checkout the 
			// codeigniter-facebook repo to a location outside of your site directory.
			// 
			// Add the 'application' directory from the repo as a package path:
			// $this->load->add_package_path('/var/www/haughin.com/codeigniter-facebook/application/');
			// 
			// Then when you want to grab a fresh copy of the code, you can just run a git pull 
			// on your codeigniter-facebook directory.

			if ( !$this->facebook->logged_in() )
			{
				// From now on, when we call login() or login_url(), the auth
				// will redirect back to this url.

				$this->facebook->set_callback(site_url('loginflow'));

				// Header redirection to auth.

				$this->facebook->login();

				// You can alternatively create links in your HTML using
				// $this->facebook->login_url(); as the href parameter.
			}
			else
			{
				redirect('loginflow');
			}
		}
		
		public function logout()
		{
			$this->facebook->logout();
			redirect('loginflow');
		}

		public function useractivity()
		{
			// var_dump($this->session->_facebook_token->__resp->data->access_token);exit();
			// exit();
			$access_token=$this->session->_facebook_token->__resp->data->access_token;	
			$response=$this->facebook->call('get','10154009990506729');
			// var_dump($response);exit();
				try {
				  // Returns a `Facebook\FacebookResponse` object
				  $response = $fb->get(
				    '/687383314630872/likes',
				    '$access_token'
				  );
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}
				$graphNode = $response->getGraphNode();
				echo "string";
				var_dump($graphNode);exit();
		}
}
