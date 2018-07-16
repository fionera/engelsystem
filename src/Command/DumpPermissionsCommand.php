<?php

namespace Engelsystem\Command;

use Doctrine\ORM\EntityManagerInterface;
use Engelsystem\Entity\Permission;
use Engelsystem\Twig\PermissionExtension;
use Engelsystem\Twig\PermissionNodeVisitor;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;
use Twig\Source;

class DumpPermissionsCommand extends Command
{

    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(Environment $environment, EntityManagerInterface $entityManager)
    {
        parent::__construct('dump:permissions');
        $this->environment = $environment;
        $this->entityManager = $entityManager;
    }


    protected function configure()
    {
        $this->setDescription('Write all Used Permissions into the Permissions Table');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        /** @var PermissionNodeVisitor $visitor */
        $visitor = $this->environment->getExtension(PermissionExtension::class)->getPermissionNodeVisitor();
        $visitor->enable();

        $di = new RecursiveDirectoryIterator(__DIR__ . '/../../templates');
        foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
            $fileNameParts = explode('.', $file->getPathname());

            if (end($fileNameParts) === 'twig') {
                $this->environment->parse($this->environment->tokenize(new Source(file_get_contents($file->getPathname()), '')));
            }
        }


        $existingPermissionEntitys = $this->entityManager->getRepository(Permission::class)->findAll();

        $existingPermissions = array_map(function (Permission $permission) {
            return $permission->getName();
        }, $existingPermissionEntitys);

        foreach ($visitor->getPermissions() as $permission) {
            if (\in_array($permission, $existingPermissions, true)) {
                continue;
            }

            $permissionEntity = new Permission();
            $permissionEntity->setName($permission);

            $this->entityManager->persist($permissionEntity);
        }

        $visitor->disable();
        $this->entityManager->flush();
    }
}