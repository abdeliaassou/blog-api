<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private $faker;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->loadUsers($manager);
        $this->loadBlogPosts($manager);
        $this->loadComments($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {
        $user = $this->getReference('user_admin');

        for ($i=0; $i<100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setAuthor($user);
            $blogPost->setTitle($this->faker->realText(45, 2));
            $blogPost->setContent($this->faker->text);
            $blogPost->setPublished($this->faker->dateTime);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post_$i", $blogPost);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {
        for ($i=0; $i < 100; $i++) {
            for ($j=0; $j < rand(1, 10); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);
                $comment->setAuthor($this->getReference('user_admin'));
                $comment->setBlogPost($this->getReference("blog_post_$i"));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Abdelilah');
        $user->setEmail('aassou.abdelilah@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'RevoK2019U!@'));
        $user->setUsername('admin');

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
