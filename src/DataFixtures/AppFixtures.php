<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");

        for ($i = 0 ; $i < 10 ; $i++) {
            $post = new Post();

            $date = $faker->dateTimeBetween('-1 year');

            $post->setAuthor($faker->name)
                ->setPublishedAt($date)
                ->setContent($faker->paragraphs(5, true))
                ->setIntroduction($faker->sentence)
                ->setTitle($faker->sentence);

            for ($j = 0 ; $j < mt_rand(0, 5) ; $j++) {
                $comment = new Comment();
                $comment->setAuthor($faker->name)
                    ->setContent($faker->paragraphs(2, true))
                    ->setPublishedAt($faker->dateTimeBetween($date))
                    ->setPost($post);

                $manager->persist($comment);
            }
            $manager->persist($post);
        }

        $manager->flush();
    }
}
