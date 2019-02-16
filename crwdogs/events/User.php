<?php

namespace crwdogs\events;

use crwdogs\events\Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{
    function verifyPassword($password) {
        return password_verify($password, $this->getPassword());
    }

    function isAdmin() {
        $groups = $this->getGroups();
        
        foreach($groups as $group) {
            if ($group->getRoot() == 'Y') {
                return true;
            }
        }

        return false;
    }

    function getGroups() {
        $userGroups = $this->getUserGroups();

        $groupIds = array();

        foreach ($userGroups as $ug) {
            array_push($groupIds, $ug->getGroupId());
        }

        return AuthGroupQuery::create()->findPKs($groupIds);
    }
}
