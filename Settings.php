<?php
/**
 * Settings page for ContactUs
 * This class handles the output for when $par == 'settings'
 * Some methods from this class are also used to parse information about email recipients.
 *
 */
class contactUs_settings extends SpecialContactUs{

    /**
     * Function to parse the options for the software. It gathers
     * data from the MediaWiki page provided to set the options.
     * @param string Page in the MediaWiki namespace, minus the 'Mediawiki:'
     * @return string Raw text of the page
     */
    public function load_user_settings($setting){
        // We can't do anything if that parameter is null.
        if ($setting == '')
            return '';
        $page = Title::newFromText($setting, NS_MEDIAWIKI);
        if (!$page->exists())
            return '';
        else {
            $page = wikiPage::factory($page);
            $cont = $page->getContent();
        }
        return $cont;
    }

    /**
     * Gathers all settings information from the mediawiki pages
     * @return array $settings
     *
     */
    public function load_all_settings(){
        $users = $this->load_user_settings('Contactus_users');

        $separate = explode('<br/>', $users->mText);
        $x = 0;
        foreach ($separate as $people){
            $name = explode('=', $people);
            $return['user'][$x]['name'] = $name[0];
            $groups = explode('|', $name[1]);
            $return['user'][$x]['groups'] = $groups;
        }

        var_dump($return);
        // $user is now $user[number][str username or array recipient groups]

        $groups = $this->load_user_settings('Contactus_groups');
        if (empty($groups))
            $group = false;
        if ($group != false){
            $group = explode('<br/>', $groups->mText);
        }
        // If any of these are true, groups aren't set, so we'll try to get them from the Contactus_users page.
        if ($group == false || empty($group))
            $group = $this->groups_from_users($user);

    }

    //$output->addElement('p', array('id' => 'debug'), $users );

    /**
     * If no groups have been set, attempts to get them from what was input on
     * the users page. If that hasn't been set, it returns false.
     * @param $array
     * @return array Groups found. Returns false if MediaWiki:Contactus_users hasn't
     * been set or was set improperly.
     */
    public function groups_from_users($array = array()){
        if (empty($array))
            return false;
        $groups = array();
        foreach ($array as $key => $val){
        }
    }

    public function buildForm(){
        $output = $this->getOutput();
        $text = '{|class="wikitable" id="contactus-settings-table"| '. wfMessage('contactus-table-settings')->Text() . '
                 | Variable
                 | Setting
                 | Location
                 | Flags
                 |-
                 | Users
                 | '.$user.'
                 | [[MediaWiki:Contactus_users]]
                 | '.$u_flags.'
                 |-
                 | Groups
                 | '.$group.'
                 | [[MediaWiki:Contactus_groups]]
                 | '.$g_flags.'
                 |-
                 |style="colspan:4;" | Other
                 |}';
        Xml::openElement('p', array('id' => 'contactus-settings-msg'));
        $output->addWikiMsg('contactus-settings-msg');
        Xml::closeElement('p');
        $output->addWikiText($text);
}


}