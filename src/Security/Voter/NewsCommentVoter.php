<?php

namespace Engelsystem\Security\Voter;

use Engelsystem\Entity\NewsComment;
use Engelsystem\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class NewsCommentVoter extends PrivilegeVoter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['POST', 'EDIT', 'VIEW'])
            && $subject instanceof NewsComment;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        switch ($attribute) {
            case 'POST':
                return $this->userHasPrivilege($user, 'news_comment_post');
                break;
            case 'EDIT':
                return $this->userHasPrivilege($user, 'news_comment_edit');
                break;
            case 'VIEW':
                return $this->userHasPrivilege($user, 'news_comment_view');
                break;
        }

        return false;
    }
}
