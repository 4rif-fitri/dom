<?php

require_once __DIR__ . '/../helpers/Mail.php';

class User extends Controller
{

	public function desboard(){
		view("/user/dashboard");
	}

	public function index()
	{
		// echo Auth::oauth("guest");

		// $this->view("/guest/login");
		view("/guest/login");
	}

	public function login()
	{
		// echo Auth::oauth("guest");

		session_start();

		if (isset($_POST["submit"])) {
			$userID = $_POST["userID"];
			$password = $_POST["password"];

			if (empty($userID)) {
				$_SESSION["error"] = "Input User ID please";
				header("Location: " . BASEURL . "/guest/login");
				exit;
			}
			if (empty($password)) {
				$_SESSION["error"] = "Input password please";
				header("Location: " . BASEURL . "/guest/login");
				exit;
			}

			$data = [
				"userID" => $userID,
				"password" => $password
			];

			$status = $this->model("UserModel")->login($data);

			// return true;

			if ($status) {
				header("Location: " . BASEURL . "/user/dashboard");
				exit;
			} else {
				$_SESSION["error"] = "Invalid credential";
				header("Location: " . BASEURL . "/guest/login");
				exit;
			}
		}

		// GET request
		$data = [
			"error" => $_SESSION["error"] ?? null
		];

		unset($_SESSION["error"]);

		view("/guest/login", $data);
	}

	public function ajax(){
		header('Content-Type: application/json');

		$data = [
			"userID" => $_POST["userID"],
			"password" => $_POST["password"]
		];

		$status = $this->model("UserModel")->login($data);

		echo json_encode([
			"status" => $status,
			"data" => $data 
		]);

		exit;
	}

	public function image(){
		header('Content-Type: application/json');
		echo json_encode([
			"data" => $_POST["imgUrl"]
		]);
	}

	public function dashboard()
	{
		// echo Auth::oauth("auth");

		// $status = send(
		// 	"d032410321@student.utem.edu.my",
		// 	"Welcome",
		// 	"Terima kasih daftar sistem kami"
		// );

		// if ($status) {
		// 	echo "Email dihantar";
		// } else {
		// 	echo "Email gagal";
		// }

		view("user/dashboard");
	}
}
