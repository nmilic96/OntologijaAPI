<?php
require 'vendor/autoload.php';
require 'bootstrap.php';

use Milic\Ontologija;
use Composer\Autoload\ClassLoader;

function parseUrl($string)
{
	$string = substr($string, strrpos($string, '/'));
	preg_match("/[^\/]+$/", $string, $matches);
	$string = $matches[0];

	$url = parse_url($string);
	if (isset($url["fragment"])) {
		return $url["fragment"];
	} else {
		return $string;
	}
};

Flight::route('GET /insert_into_table', function () {
	$foaf = \EasyRdf\Graph::newAndLoad('https://oziz.ffos.hr/nastava20192020/nmilic_19/milic.rdf');

	foreach ($foaf->resources() as $resource) {
		$resourceName = parseUrl($resource);
		if (strlen($resourceName) > 0) {

			$resourceTypes = $resource->types();
			$resourceTypes = implode($resourceTypes, ', ');

			$resourceData = [];
			if (isset($resourceTypes)) {
				foreach ($resource->propertyUris() as $key) {
					$validKey = '<' . $key . '>';
					$values = $foaf->get($resource, $validKey);
					$str = parseUrl($key) . ': ' . parseUrl($values);
					echo($str) . '<br>';
					array_push($resourceData, $str);
				}
			};

			$resourceData = implode($resourceData, "\n");

			$ontology = new Ontologija();
			$ontology->setData(Flight::request()->data);
			$ontology->setResourceName($resourceName);
			$ontology->setResourceType($resourceTypes);
			$ontology->setResourceData($resourceData);

			$doctrineBootstrap = Flight::entityManager();
			$em = $doctrineBootstrap->getEntityManager();
			$em->persist($ontology);
			$em->flush();
		}
	}
});

function getAllData() {
	$doctrineBootstrap = Flight::entityManager();
	$em = $doctrineBootstrap->getEntityManager();
	$repo = $em->getRepository('Milic\Ontologija');
	$items = $repo->findAll();
	echo $doctrineBootstrap->getJson($items);
}

Flight::route('GET /', function () {
	getAllData();
});

Flight::route('GET /search', function () {
	getAllData();
});

Flight::route('GET /search/@term', function ($val) {
	$doctrineBootstrap = Flight::entityManager();
	$em = $doctrineBootstrap->getEntityManager();
	$repo = $em->getRepository('Milic\Ontologija');
	$items = $repo->createQueryBuilder('r')
		->where('r.resourceName LIKE :term OR r.resourceData LIKE :term')
		->setParameter('term', '%' . $val . '%')
		->getQuery()
		->getResult();
	echo $doctrineBootstrap->getJson($items);
});

$cl = new ClassLoader('Milic', __DIR__, '/src');
$cl->register();
require_once 'bootstrap.php';
Flight::register('entityManager', 'DoctrineBootstrap');
Flight::start();
