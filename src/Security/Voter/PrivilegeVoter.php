<?php

namespace Engelsystem\Security\Voter;


use Engelsystem\Entity\Group;
use Engelsystem\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class PrivilegeVoter extends Voter
{
    public function groupHasPrivilege(Group $group, string $searchedPrivilege): bool
    {
        foreach ($group->getPermissions() as $privilege) {
            if ($privilege->getName() === $searchedPrivilege) {
                return true;
            }
        }

        return false;
    }

    public function userHasPrivilege(User $user, string $searchedPrivilege): bool
    {
        foreach ($user->getGroups() as $group) {
            foreach ($group->getPermissions() as $privilege) {
                if ($privilege->getName() === $searchedPrivilege) {
                    return true;
                }
            }
        }

        return false;
    }
}