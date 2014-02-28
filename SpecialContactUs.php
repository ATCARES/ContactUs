<?php
/** ContactUs class
* This is what is executed when a user accesses Special:ContactUs
*/
if (!defined('MEDIAWIKI'))
    die("Not a valid entry point.");

// Include the settings class.
include_once(__DIR__ . '/Settings.php');

class SpecialContactUs extends SpecialPage {
    /** @var \User
     A user object to work with. */
    protected $user;
    /** @var array People who will receive emails */
    public $recipients;
    /** @var array Recipient groups */
    public $groups;
    /**
     * Constructor. Sets up the settings and User objects, then
     * calls the parent's constructor.
      */
    function __construct(){
        // Make $this->settings into a settings object
        $this->settings = new contactUs_settings();
        // Make $this->user into a user object
        $this->user = $this->getUser();
        // And get the result of the parent constructor.
		parent::__construct( 'ContactUs' );
    }

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
            $cont = $cont->mText;
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

        $separate = explode('<br/>', $users);
        $x = 0;
        foreach ($separate as $people){
            $name = explode('=', $people);
            $return['user'][$x]['name'] = $name[0];
            $groups = explode('|', $name[1]);
            $return['user'][$x]['groups'] = $groups;
        }

        $groups = $this->load_user_settings('Contactus_groups');
        if ($groups == '')
            $group = false;
        if ($group != false){
            $group = explode('<br/>', $groups);
        }
        // If any of these are true, groups aren't set, so we'll tell the script to use something else.
        if (($group == false || empty($group)))
            $this->no_groups = true;

        $custom = $this->load_user_settings('Contactus-custom-message');
        if ($custom != '')
            $return['custom_message'] = $custom;

        $reasons = $this->load_user_settings('Contactus-contact-reasons');
        if ($reasons != ''){
            $return['reasons'] = $reasons;
        }
        return $return;

    }
    /** This checks permissions and throws a mwException if they are insufficient */
    public function checkPermissions($perm){
        if (!$this->user->isAllowed([$perm]))
            $this->displayRestrictionError();
    }
    /** This function handles the extension's output */
    protected function build_form($type){
        if ($type == 'email'){
            $output = $this->getOutput();
            $settings = $this->load_all_settings();
            if ($settings['custom_message'] && $settings['custom_message'] != '')
                $output->addWikiText($settings['custom_message']);
            else
                $output->addWikiMsg('contactus-page-desc');

            Xml::openElement("div", array('id' => 'contactus_form_wrapper'));
            Html::openElement('form', array('name' => 'contactus_form', 'method' => 'post', 'id' => 'contactus_form'));
            Xml::openElement('label', array('for' => 'user-email'));
            $output->addWikiMsg('contactus-your-email');
            Xml::closeElement('label');
            $output->addElement("input", array("type" => 'text', "size" => 60, 'name' => 'user-email', 'id' => 'contactus_email_input'));
            Xml::openElement('label', array('for' => 'user-alias'));
            $output->addWikiMsg('contactus-your-username');
            Xml::closeElement('label');
            $output->addElement("input", array("type" => 'text', "size" => 60, 'name' => 'user-alias', 'id' => 'contactus_alias_input'));
            $output->addWikiMsg('contactus-problem-question');
            Xml::openElement('select', array("name" => 'contact_reason', 'id' => 'contactus-contact-reason'));
            if (!$settings['custom_reasons'])
                $settings['custom_reasons'] = array('tech' => 'Report a bug or issue', 'affiliate' => 'Request affiliation', 'other' => 'Other');
            foreach ($settings as $key => $val){

            }
        }
        elseif ($type == 'settings'){
            $text = '{|class="wikitable" id="contactus-settings-table"| '.wfMessage('contactus-table-settings')->Text() . '
                 | '.wfMessage('contactus-table-variable')->Text() . '
                 | '.wfMessage('contactus-table-value')->Text() . '
                 | '.wfMessage('contactus-table-page')->Text() . '
                 |-
                 | '.wfMessage('contactus-table-users')->Text() . '
                 | '.$user.'
                 | [[MediaWiki:Contactus_users]]
                 |-
                 | '.wfMessage('contactus-table-groups') . '
                 | '.$group.'
                 | [[MediaWiki:Contactus_groups]]
                 |-
                 |style="colspan:4;" | Other
                 | '.wfMessage('contactus-table-custom') . '
                 |
                 |}';
            Xml::openElement('p', array('id' => 'contactus-settings-msg'));
            $output->addWikiMsg('contactus-settings-msg');
            Xml::closeElement('p');
            $output->addWikiText($text);
        }
    }

    /**
     * Resolve what the user is trying to do
     * @param null|string $par (intended to be called via $this->execute, with $par from that function as input)
     * @return string telling us what the user is trying to do
     */
    protected function resolve_request($par){
        $request = $this->getRequest();
        if ($request->getText('action') == 'submit' && strtolower($par) == 'settings')
            $submit = true;
        if (strtolower($par) == 'settings')
            $page = 'settings';
        elseif ($par != ''){

            // @todo: Message for the user stating that there are no subpages of this. It's kinda lying, but they don't need to change settings.
        }
    }
    /**
     * This function actually sends the email.
     */
    protected function send_mail(){

    }
    /**
    * Page execution.
    * @param null|string $par
     */
    function execute( $par ) {
        $context = $this->resolve_request($par);
        // execute must call this
        $this->setHeaders();
        if ($request->getText('action') == 'submit' && strtolower($par) != 'settings')
            $this->send_mail();
        $this->build_form('email');



}
}
