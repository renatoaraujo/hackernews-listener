<?php

namespace App\Command;

use App\Service\HackerNews;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ExecuteCommand extends Command
{
    protected static $defaultName = 'listener:execute';

    /** @var HackerNews */
    private $hackerNewsService;

    public function __construct(HackerNews $hackerNewsService)
    {
        $this->hackerNewsService = $hackerNewsService;
        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setDescription('Execute the API call with new stories from HackerNews.')
            ->setHelp('This command allows you to execute the API call to HackerNews API.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $topStories = $this->hackerNewsService->topStories();
        $items = [];

        // produce a message with the storyid on rabbitmq

//        foreach ($topStories as $storyId) {
//            $items[$storyId] = $this->hackerNewsService->item($storyId);
//        }

//        dump($items);
    }
}
