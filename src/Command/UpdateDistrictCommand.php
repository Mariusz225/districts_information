<?php

namespace App\Command;

use App\Command\DownloadDistrict\UpdateDistrictInterface;
use App\Command\DownloadDistrict\UpdateGdanskDistrict;
use App\Command\DownloadDistrict\UpdateKrakowDistrict;
use App\Service\Http\HttpService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

#[AsCommand(
    name: 'app:download-districts',
    description: 'Download districts.',
    aliases: ['app:download-districts'],
    hidden: false
)]
class UpdateDistrictCommand extends Command
{
    public function __construct(
        private readonly HttpService $httpService,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select district to upload (defaults all)',
            [
                new UpdateGdanskDistrict($this->httpService, $this->entityManager),
                new UpdateKrakowDistrict($this->httpService, $this->entityManager)
            ],
            '0,1'
        );
        $question->setMultiselect(true);

        $selectedDistrictCities = $helper->ask($input, $output, $question);

        foreach ($selectedDistrictCities as $selectedDistrictCity) {
            /** @var UpdateDistrictInterface $selectedDistrictCity */
            $output->writeln('Districts for ' . $selectedDistrictCity . ' have started updating.');
            $selectedDistrictCity->updateDistricts();
            $output->writeln('The district for ' . $selectedDistrictCity . ' has been updated.');
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to upload districts...');
    }
}
