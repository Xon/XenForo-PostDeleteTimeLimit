<?php

class SV_PostDeleteTimeLimit_XenForo_Model_Post extends XFCP_SV_PostDeleteTimeLimit_XenForo_Model_Post
{
    public function canDeletePost(array $post, array $thread, array $forum, $deleteType = 'soft', &$errorPhraseKey = '', array $nodePermissions = null, array $viewingUser = null)
    {
        $ret = parent::canDeletePost($post, $thread, $forum, $deleteType, $errorPhraseKey, $nodePermissions, $viewingUser);
        if (!$ret ||
            ($post['post_id'] == $thread['first_post_id'] && XenForo_Permission::hasContentPermission($nodePermissions, 'deleteAnyThread')) ||
            XenForo_Permission::hasContentPermission($nodePermissions, 'deleteAnyPost')
            )
        {
            return $ret;
        }

        $editLimit = XenForo_Permission::hasContentPermission($nodePermissions, 'deleteOwnPostTimeLimit');

        if ($editLimit != -1 && (!$editLimit || $post['post_date'] < XenForo_Application::$time - 60 * $editLimit))
        {
            $errorPhraseKey = array('message_edit_time_limit_expired', 'minutes' => $editLimit);
            return false;
        }

        return true;
    }
}
