<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $blogPost = new BlogPost();
        $blogPost->setAuthor('Abdelilah Aassou');
        $blogPost->setTitle('Chmosky and Neo-Atheism!');
        $blogPost->setContent('In a new interview, Chmosky revealed that the Neo-Atheism movement...');
        $blogPost->setPublished(new \DateTime('2019-06-30 17:40:00'));
        $blogPost->setSlug('chomsky-neo-atheism');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setAuthor('Abdelilah Aassou');
        $blogPost->setTitle('Greek philosophy, Christianity and the Neo-Atheism');
        $blogPost->setContent('What are the main characteristics shared between these three ideas...');
        $blogPost->setPublished(new \DateTime('2019-07-01 17:44:00'));
        $blogPost->setSlug('greek-philosophy-christianity-neo-atheism');

        $manager->persist($blogPost);

        $faker = Factory::create();

        for ($i=0; $i<100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setAuthor($faker->name);
            $blogPost->setTitle($faker->realText(45, 2));
            $blogPost->setContent($faker->text);
            $blogPost->setPublished(new \DateTime());
            $blogPost->setSlug($faker->slug);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }
}
