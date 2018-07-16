<?php

namespace Engelsystem\Twig;

use Engelsystem\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PermissionExtension extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $permissionNodeVisitor;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('hasPermission', [$this, 'hasPermission']),
        ];
    }

    public function hasPermission($value)
    {
        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return false;
        }

        /** @var UserInterface $user */
        $user = $token->getUser();

        if (!($user instanceof User)) {
            return false;
        }

        return $user->hasPermission($value);
    }

    public function getNodeVisitors()
    {
        return [$this->getPermissionNodeVisitor()];
    }

    public function getPermissionNodeVisitor()
    {
        return $this->permissionNodeVisitor ?: $this->permissionNodeVisitor = new PermissionNodeVisitor();
    }
}
