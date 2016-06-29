<?php
class SV_PostDeleteTimeLimit_Installer
{
    public static function install($existingAddOn, array $addOnData, SimpleXMLElement $xml)
    {
        $version = isset($existingAddOn['version_id']) ? $existingAddOn['version_id'] : 0;
        if (XenForo_Application::$versionId < 1030070)
        {
            throw new Exception('XenForo 1.3.0+ is Required!');
        }

        $db = XenForo_Application::getDb();
    }

    public static function uninstall()
    {
        $db = XenForo_Application::getDb();

        $db->query(" 
             delete from xf_permission_entry
             where permission_id = 'deleteOwnPostTimeLimit'
        ");
        $db->query(" 
             delete from xf_permission_entry_content 
             where permission_id = 'deleteOwnPostTimeLimit'
        ");

        // rebuild permissions
        XenForo_Application::defer('Permission', array(), 'Permission', true);
    }
}