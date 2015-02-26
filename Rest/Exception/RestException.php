<?php

/**
 * Exception class.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Exception
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */

namespace AMF\WebServicesClientBundle\Rest\Exception;

/**
 * Exception class.
 *
 * @package AMFWebServicesClientBundle
 * @subpackage Exception
 * @author Mohamed Amine Fattouch <amine.fattouch@gmail.com>
 */
class RestException extends \Exception
{
    
    /**
     * @var array
     */
    protected $data;
    
    
    /**
     * The constructor class.
     *
     * @param string     $message  The internal exception message.
     * @param \Exception $previous The previous exception.
     * @param integer    $code     The internal exception code.
     * @param array      $data     The wrong data.
     */
    public function __construct($message=null, $code=0, \Exception $previous=null, array $data=array())
    {
        parent::__construct($message, $code, $previous);
        
        $this->data = $data;
    }
    
    /**
     * The getter for data.
     * 
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
