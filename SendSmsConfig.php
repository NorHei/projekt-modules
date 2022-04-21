<?php  namespace ProcessWire;

/**
* This File is the backend configuration for this module.
* PW allows for easy generation of module configurations  
*/
class SendSmsConfig extends ModuleConfig {

  	/**
    * Define default values for configuration settings 
	*/
    public function getDefaults() {
        return array(
	    	// Just the test API
           	'token'  => 'lSKZIRA4GpsqENF86fxt2ZEgVjsYdbvPwevSYg7oFR5tJIae8ORr4WnmqKv9i6ZH',
      		'sender' => 'Sensors',
    	);
  	}

    /**
	* Define the input fields for the configuration settings
	*/
  	public function getInputfields() {
    	$inputfields = parent::getInputfields();

    	$f = $this->modules->get('InputfieldText');
    	$f->attr('name', 'token');
    	$f->label = 'SMS77 Service Token';
    	$f->required = true;
    	$inputfields->add($f);

    	$f = $this->modules->get('InputfieldText');
    	$f->attr('name', 'sender');
    	$f->label = 'Sender Name (max. 11 Zeichen)';
    	$f->required = true;
    	$inputfields->add($f);

    	return $inputfields;
  	}
}
