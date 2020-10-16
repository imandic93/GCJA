<?php

namespace App\Command;

use App\Contract\Repository\PostRepositoryInterface;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class PostsFetchCommand extends Command
{
    protected static $defaultName = 'app:posts:fetch';
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var string
     */
    private $externalApiBaseUrl;
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    public function __construct(HttpClientInterface $httpClient,
                                EntityManagerInterface $entityManager,
                                string $externalApiBaseUrl,
                                PostRepositoryInterface $postRepository,
                                string $name = null)
    {
        parent::__construct($name);
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->externalApiBaseUrl = $externalApiBaseUrl;
        $this->postRepository = $postRepository;
    }

    protected function configure(): void
    {
        $this->setDescription("Fetching posts from external API located at {$this->externalApiBaseUrl}");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $response = $this->httpClient->request(
                Request::METHOD_GET,
                $this->externalApiBaseUrl . '/posts'
            );

            $posts = $response->toArray();
        } catch (Throwable $e) {
            $io->error('Failed getting success response from API');

            return Command::FAILURE;
        }

        $savedPostsDict = [];

        foreach ($this->postRepository->getAll() as $post) {
            $savedPostsDict[$post->getExternalApiId()] = $post;
        }

        foreach ($posts as $post) {
            if (isset($savedPostsDict[$post['id']])) {
                $postToBeSaved = $savedPostsDict[$post['id']];
            } else {
                $postToBeSaved = new Post();
                $postToBeSaved->setExternalApiId($post['id']);
            }

            $postToBeSaved->setTitle($post['title']);
            $postToBeSaved->setBody($post['body']);

            $this->entityManager->persist($postToBeSaved);
        }

        $this->entityManager->flush();

        $io->success('Successfully fetched comments');

        return Command::SUCCESS;
    }
}
