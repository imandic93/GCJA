<?php

namespace App\Command;

use App\Contract\Repository\UserRepositoryInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UsersFetchCommand extends Command
{
    protected static $defaultName = 'app:users:fetch';
    /**
     * @var HttpClientInterface
     */
    private $httpClient;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var string
     */
    private $externalApiBaseUrl;

    public function __construct(HttpClientInterface $httpClient,
                                EntityManagerInterface $entityManager,
                                UserRepositoryInterface $userRepository,
                                string $externalApiBaseUrl,
                                string $name = null)
    {
        parent::__construct($name);
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->externalApiBaseUrl = $externalApiBaseUrl;
    }

    protected function configure(): void
    {
        $this->setDescription("Fetching users from external API located at {$this->externalApiBaseUrl}");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $response = $this->httpClient->request(
                Request::METHOD_GET,
                $this->externalApiBaseUrl . '/users'
            );

            $users = $response->toArray();
        } catch (\Throwable $e) {
            $io->error('Failed getting success response from API');

            return Command::FAILURE;
        }

        $savedUsersDict = [];

        foreach ($this->userRepository->getAll() as $user) {
            $savedUsersDict[$user->getExternalApiId()] = $user;
        }

        foreach ($users as $user) {
            if (isset($savedUsersDict[$user['id']])) {
                $newUser = $savedUsersDict[$user['id']];
            } else {
                $newUser = new User();
                $newUser->setExternalApiId($user['id']);
            }

            $newUser->setName($user['name']);
            $newUser->setEmail($user['email']);
            $newUser->setUsername($user['username']);

            $this->entityManager->persist($newUser);
        }
        $this->entityManager->flush();

        $io->success('Successfully fetched users');

        return Command::SUCCESS;
    }
}
