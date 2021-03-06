<?php

namespace Engelsystem\Command;

use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\Group;
use Engelsystem\Entity\Permission;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateGroupCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct('create:group');
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->addArgument('groupName', InputArgument::OPTIONAL, 'Group Name')
            ->addOption('admin', '', InputOption::VALUE_NONE , 'Is Admin')
            ->setDescription('Create a Group');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $groupName = $input->getArgument('groupName');
        $admin = $input->getOption('admin');

        if (!$groupName) {
            $groupName = $io->ask('Group Name?: ');
        }

        $groupEntity = new Group();
        $groupEntity->setName($groupName);

        if ($admin) {
            $permissions = $this->entityManager->getRepository(Permission::class)->findAll();
            foreach ($permissions as $permission) {
                $groupEntity->addPermission($permission);
            }
        }

        $this->entityManager->persist($groupEntity);
        $this->entityManager->flush();

        $io->success('Group created!');
    }
}
