<?php

namespace App\Command;

use App\Service\HackerNews;
use Aws\Sqs\SqsClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExecuteCommand extends Command
{
    protected static $defaultName = 'listener:execute';

    /** @var HackerNews */
    private $hackerNewsService;

    /** @var SqsClient */
    private $client;

    public function __construct(HackerNews $hackerNewsService, SqsClient $client)
    {
        $this->hackerNewsService = $hackerNewsService;
        $this->client = $client;
        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setDescription('Execute the API call with new stories from HackerNews.') //@todo change this later for more reasonable description
            ->setHelp('This command allows you to execute the API call to HackerNews API.'); //@todo this one too
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //@todo Isolate the service to call the api and process whatever it will be processed on
        $topStories = $this->hackerNewsService->topStories();

        // @todo discover if it's possible to send multiple messages to queue
        foreach ($topStories as $topStory) {

            // @todo Create a proper service/adapter/whatever to queue the messages
            $this->client->sendMessage([
                'QueueUrl'    => getenv('MQ_URL'), // don't do it at home my friends!
                'MessageBody' => $topStory,
            ]);
        }

        $output->writeln('End of execution');
    }
}
