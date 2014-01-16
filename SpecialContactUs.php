<?php
/** ContactUs class
* This is what is executed when a user accesses Special:ContactUs
*/
class SpecialContactUs extends SpecialPage {
	function __construct() {
		parent::__construct( 'ContactUs' );
	}
 
    function cu_prepareDB() {
        $dbr = wgGetDB(DB_SLAVE);
        $dbw = wfGetDB(DB_MASTER);
        
    }
 
	function execute( $par ) {
        global $wgOut;
		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();
 
		# Get request data from, e.g.
		$param = $request->getText( 'param' );
 
		# Do stuff
		# ...
        
	}
}



?>