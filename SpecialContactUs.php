<?php
/** ContactUs class
* This is what is executed when a user accesses Special:ContactUs
*/
if (!defined('MEDIAWIKI'))
    die("Not a valid entry point.");

// Include the settings class.
include_once(__DIR__ . '/Settings.php');

class SpecialContactUs extends SpecialPage {
    /** @var \contactUs_settings
     *  Includes methods for building the settings page*/
    private $settings;
    /** @var \User
     A user object to work with.*/
    protected $user;

    /** Constructor */
    function __construct(){
        // Make $this->settings into a settings object
        $this->settings = new contactUs_settings();
        // Make $this->user into a user object
        $this->settings = $this->getUser();
        // And get the result of the parent constructor.
		parent::__construct( 'ContactUs' );
    }

    /** This checks permissions and throws a mwException if they are insufficient */
    public function checkPermissions($perm){
        if (!$this->user->isAllowed([$perm]))
            $this->displayRestrictionError();
    }
    /** This function handles the extension's output */
    protected function build_form(){
        $output = $this->getOutput();
        $settings = $this->settings->load_all_settings();
        if ($settings['custom_message'] && $settings['custom_message'] != '')
            $output->addWikiText($custom['mText']);
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
        $request = $this->getRequest();
        // execute must call this
        $this->setHeaders();
        if ($request->getText('action') == 'submit' && strtolower($par) != 'settings')
            $this->send_mail();

        // Get all configuration values.
        $settings = new contactUs_settings();
        $settings->buildForm();

}
}
?>