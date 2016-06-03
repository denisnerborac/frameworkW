<?php

namespace Controller;

use \W\Controller\Controller;
use Manager\MovieManager;

class MovieController extends Controller
{
	private $manager;

	public function __construct() {
		$this->manager = new UserManager();
	}

	public function view($id)
	{
		$movie = $this->manager->find($id);

		$this->show('movie/view', array('movie' => $movie));
	}

	public function random()
	{
		$movie = $this->manager->getRandom();

		$this->show('movie/random', array('movie' => $movie));
	}

	public function catalog()
	{
		$movies = $this->manager->findAll();

		$this->show('movie/catalog', array('movies' => $movies));
	}

	public function search($search) {

		$search = htmlspecialchars($search);
		$search = urldecode($search);

		$movies = $this->manager->search($search);

		$this->show('movie/search', array('movies' => $movies));
	}

	public function add()
	{
		$title = !empty($_POST['title']) ? strip_tags($_POST['title']) : '';
		$synopsis = !empty($_POST['synopsis']) ? strip_tags($_POST['synopsis']) : '';

		$errors = array();
		$result = false;

		if (!empty($_POST)) {

			if (empty($title)) {
				$errors['title'] = 'Le titre est obligatoire';
			}
			if (empty($synopsis)) {
				$errors['synopsis'] = 'Le synopsis est obligatoire';
			}

			if (empty($errors)) {
				$created_movie = $this->manager->insert(array(
					'title' => $title,
					'synopsis' => $synopsis,
				));

				$result = $created_movie;
			}
		}

		$this->show('movie/add', array(
			'errors' => $errors,
			'result' => $result,
			'title' => $title,
			'synopsis' => $synopsis
		));
	}

}