<?php

namespace Engelsystem\Security\Voter;

use Engelsystem\Entity\News;
use Engelsystem\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class NewsVoter extends PrivilegeVoter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['POST', 'EDIT'])
            && $subject instanceof News;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case 'POST':
                return $this->userHasPrivilege($user, 'news_post');
                break;
            case 'EDIT':
                return $this->userHasPrivilege($user, 'news_edit');
                break;
        }

        return false;
    }
}
