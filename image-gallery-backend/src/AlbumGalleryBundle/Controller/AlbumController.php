<?php

namespace AlbumGalleryBundle\Controller;

use AlbumGalleryBundle\Entity\Album;
use AlbumGalleryBundle\Entity\Image;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AlbumController extends Controller
{
	/**
	 * A method to get all albums
	 */
	public function getAllAction()
	{
		// Load services
		$em = $this->getDoctrine()->getManager();
		$manager = $this->get('album_gallery.api_manager');
		$repo = $em->getRepository('AlbumGalleryBundle:Album');

		// Find albums
		$albums = $repo->findAll();
		return $manager->createResponse($albums);
	}

	/**
	 * A method to get album by unique id
	 */
	public function getByIdAction($album_id)
	{
		// Load services
		$em         = $this->getDoctrine()->getManager();
		$img_repo   = $em->getRepository('AlbumGalleryBundle:Image');
		$album_repo = $em->getRepository('AlbumGalleryBundle:Album');
		$manager    = $this->get('album_gallery.api_manager');

		// Find and extend album
		$album = $album_repo->findOneById($album_id);
		$album->count = $img_repo->count($album_id);

		return $manager->createResponse($album);
	}

	/**
	 * A method to get images of spec. album by id
	 */
	public function getImagesAction($album_id, $page)
	{
		// Load services
		$em      = $this->getDoctrine()->getManager();
		$repo    = $em->getRepository('AlbumGalleryBundle:Image');
		$manager = $this->get('album_gallery.api_manager');

		// Find images
		$images = $repo->pagination($page, $album_id);

		return $manager->createResponse($images);
	}

	/**
	 * A method to create new album
	 */
	public function newAction(Request $request)
	{
		// Load services
		$manager   = $this->get('album_gallery.api_manager');
		$validator = $this->get('validator');

		// Prepare input data
		$params = $this->getRequest()->query->all();
		$album = new Album($params);
		$errors = $validator->validate($album);

		// Check errors
		if (count($errors) > 0) {
			return $manager->createResponse($errors); 
		}

		// Storage new album
		$em = $this->getDoctrine()->getManager();
		$em->persist($album);
		$em->flush();

		return $manager->createResponse($album);
	}

	public function deleteAction($album_id)
	{
		// Load services
		$em         = $this->getDoctrine()->getManager();
		$manager    = $this->get('album_gallery.api_manager');

		// Prepare input data
		$album_id = (int)$album_id;
		$album = $em->getReference('AlbumGalleryBundle:Album', $album_id);

		if ($album_id <= 0) {
			$manager->createResponse(new \Exception('Incorrect album id'));
		}

		$em->remove($album);
		$em->flush();

		return $manager->createResponse('ok');
	}

	/**
	 * A method to create new album
	 */
	public function newImageAction($album_id)
	{
		// Load services
		$em         = $this->getDoctrine()->getManager();
		$img_repo   = $em->getRepository('AlbumGalleryBundle:Image');
		$album_repo = $em->getRepository('AlbumGalleryBundle:Album');
		$manager    = $this->get('album_gallery.api_manager');
		$validator  = $this->get('validator');

		// Prepare input data
		$params = $this->getRequest()->request->all();
		$image = new Image($params);

		$errors = $validator->validate($image);

		// Check errors
		if (count($errors) > 0) {
			return $manager->createResponse($errors); 
		}

		// Check album existing
		if (!$album_repo->exist($album_id)) {
			return $manager->createResponse(new \Exception('Album not exist')); 
		}

		$image->setAlbum($em->getReference('AlbumGalleryBundle:Album', $album_id));

		// Storage new image
		$em = $this->getDoctrine()->getManager();
		$em->persist($image);
		$em->flush();

		return $manager->createResponse($image);
	}

	public function deleteImageAction($album_id, $image_id)
	{
		// Load services
		$em         = $this->getDoctrine()->getManager();
		$manager    = $this->get('album_gallery.api_manager');

		// Prepare input data
		$image = $em->getReference('AlbumGalleryBundle:Image', $image_id);

		if ($image_id <= 0) {
			$manager->createResponse(new \Exception('Incorrect image id'));
		}

		$em->remove($image);
		$em->flush();

		return $manager->createResponse('ok');
	}
}
