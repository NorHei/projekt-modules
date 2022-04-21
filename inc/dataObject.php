<?php namespace ProcessWire;

/**
 * Transform sensor data into a Data Object and do some basic validation and sanitation
 * 
 * Still the application needs to do some checks, but a lot of crap is filtered out.  
 * In addition this class is used for testing the test Sensor class in recieve.php
 */
class dataObject {
      
    /** @var string $title */
    public $title;
    
    /** @var string $hash */
    public $hash;
    
    /** @var float|int $tempValue */
    public $tempValue;
    
    /** @var float|int $temperature */
    public $temperature;
    
    /** @var int $co2Ppm */
    public $co2Ppm;
    
    /** @var float|int $co2Value */
    public $co2Value;
    
    /** @var string $ipAddress*/
    public $ipAddress;


    /**
     * Deserialize static method 
     * 
     * This is more or less a self factory that creates an instance of the dataclass and fills 
     * it whith the attribures aqired from JSON string. If there are inconsintencies whith 
     * those attributes it will fail and return an empty object.
     * 
     *  @param string $jsonString
     *
     *  @return object/false 
     */
    public static function Deserialize($jsonString)
    {
        $classInstance = new DataObject();
        
        // needed for check if all are filled
        $cProperties = count((array)$classInstance);

        $jsonArray = json_decode($jsonString);
        
        $cFilled = 0;

        foreach ($jsonArray as $key => $value) {
            if (!property_exists($classInstance, $key)) continue;

            $classInstance->{$key} = $value;
            $cFilled++;
        }
        
        // All properties have benn filled?
        if ($cFilled == $cProperties ){
            // Validation ok so return Object
            if ($classInstance->basicValidation()){
                // but some basic sanitation first
                $classInstance->basicSanitation();
                return $classInstance;
            }
            else {
                echo"Basic Validation failed!\n"; 
            }

        } 
        else {
            echo"Invalid properties filled: $cFilled  / Properties: $cProperties\n"; 
        }

        // concerning PHP manual its better to use both
        $classInstance = NULL;
        unset($classInstance);

        return (object)[];   // Returns empty Object
    } 
    

    /**
     * Basic Validation class 
     * 
     * Returns True if validation is OK , false otherwise
     * 
     * @return bool 
     */
    protected function basicValidation() {
        
        if (!preg_match("/^(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])(.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]|[0-9])){3}$/", $this->ipAddress)) {
            echo("IPAdress Validation Failed{$this->ipAddress}\n");
            return false;
        }
            
        if (!is_string($this->title) OR strlen($this->title) > 250 ){
            echo("Title Validation Failed: {$this->title}\n");
            return false;
        }
    
        if (!is_string($this->hash) OR strlen($this->hash) > 250 ){
            echo("Hash Validation Failed: {$this->hash}\n");
            return false;
        }

        if (!is_numeric($this->tempValue)){
            echo("TempValue Validation Failed: {$this->tempValue}\n");
            return false;
        }
 
        if (!is_numeric($this->temperature)){
            echo("Temperature Validation Failed: {$this->temperature}\n");
            return false;
        }
     
        if (!is_numeric($this->co2Ppm)){
            echo("Co2Ppm Validation Failed: {$this->co2Ppm}\n");
            return false;
        }
 
        if (!is_numeric($this->co2Value)){
            echo("co2Value Validation Failed: {$this->co2Value} \n");
            return false;
        }
        
        return true;

    }

    /**
     * Just some really basic sanitation.
     * 
     * @return void
     */
    protected function basicSanitation() {
        
        $this->tempValue = (float)$this->tempValue;
        $this->temperature= (float)$this->temperature;
        $this->co2Ppm= (int)$this->co2Ppm;
        $this->co2Value= (float)$this->co2Value;

    }
}
