<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 *
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello world!'
        ],
        [
            'id' => 2,
            'slug' => 'another-post',
            'title' => 'This is another post!'
        ],
        [
            'id' => 3,
            'slug' => 'last-post',
            'title' => 'This is the last post!'
        ],


    ];

    /**
     * @Route("/{page}", name="blog_list", defaults={"page":1})
     *
     * @param $page
     * @param Request $request
     * @return JsonResponse
     */
    public function list($page, Request $request) {
        $limit = $request->get('limit', 10);

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function($item) {
                return $this->generateUrl('blog_by_slug', ['slug' => $item['slug']]);
            }, self::POSTS)
        ]);
    }

    /**
     * @Route("/{id}", name="blog_by_id", requirements={"id"="\d+"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function post($id) {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }

    /**
     * @Route("/{slug}", name="blog_by_slug")
     *
     * @param $slug
     * @return JsonResponse
     */
    public function postBySlug($slug) {
        return $this->json(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}