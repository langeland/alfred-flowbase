<?php


namespace FlowBase;

/**
 * Class Environment
 * @package FlowBase
 * @see https://www.alfredapp.com/help/workflows/script-environment-variables/
 */
class Environment
{






/*

Array
(
    [alfred_theme] => theme.bundled.dark
    [alfred_workflow_bundleid] => info.langeland.jira
    [alfred_version_build] => 961
    [alfred_theme_subtext] => 0
    [alfred_workflow_name] => Jira
    [alfred_version] => 3.8.1
    [alfred_workflow_uid] => user.workflow.EB56EA27-835D-45CD-859E-66E6C9799C4E
    [alfred_workflow_cache] => /Users/jolj/Library/Caches/com.runningwithcrayons.Alfred-3/Workflow Data/info.langeland.jira
    [alfred_workflow_data] => /Users/jolj/Library/Application Support/Alfred 3/Workflow Data/info.langeland.jira
    [alfred_theme_selection_background] => rgba(53,129,136,1.00)
    [alfred_preferences] => /Users/jolj/Library/Application Support/Alfred 3/Alfred.alfredpreferences
    [alfred_theme_background] => rgba(0,0,0,0.78)
    [alfred_preferences_localhash] => 1089fb89fbd0200b285a63901224ce2bafc61952
)


*/

    /**
     * Environment constructor.
     */
    public function __construct()
    {
        if(is_dir($_SERVER['alfred_workflow_cache']) === false){
            mkdir($_SERVER['alfred_workflow_cache'], 0777, true);
        }

        if(is_dir($_SERVER['alfred_workflow_data']) === false){
            mkdir($_SERVER['alfred_workflow_data'], 0777, true);
        }
    }


    public function getVariable($key, $default = null)
    {
        if(array_key_exists($key, $_SERVER)){
            return $_SERVER[$key];
        } else {
            return $default;
        }
    }


}