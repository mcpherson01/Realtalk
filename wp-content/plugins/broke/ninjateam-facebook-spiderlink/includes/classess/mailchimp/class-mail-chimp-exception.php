<?php 

	/**
	* 
	*/
	class NjJ_SPIDERLINK_MAIL_CHIMP_EX extends Exception
	{
		public $response;
    	public $type = '';
    	public $title = '';
    	public $status = '';
    	public $detail = '';
    	public $instance = '';
    	public $errors = array();

		function __construct($message, $code, $response = null, $data = null ){

			parent::__construct( $message, $code );
			$this->response = $response;
			if( ! empty( $data ) ) {

            // fill error properties from json data
            $error_properties = array( 'type', 'title', 'status', 'detail', 'instance', 'errors' );
            foreach( $error_properties as $key ) {
                if( ! empty( $data->$key ) ) {

                    $this->$key = $data->$key;
                    
                }
           		}
       		}

		}

		public function __toString() {
        $string = $this->message . '.';

        if( ! empty( $this->detail ) ) {
            $string .= ' ' . $this->detail;
        }


        if( ! empty( $this->errors ) && isset( $this->errors[0]->field ) ) {

            // strip off obsolete msg
            $string = str_replace( 'For field-specific details, see the \'errors\' array.', '', $string );

            // generate list of field errors
            $field_errors = array();
            foreach( $this->errors as $error ) {
                if( ! empty( $error->field ) ) {
                    $field_errors[] = sprintf( '- %s : %s', $error->field, $error->message );
                } else {
                    $field_errors[] = sprintf( '- %s', $error->message );
                }
            }

            $string .= " \n" . join( "\n", $field_errors );
        }

        return $string;
    }



	}

?>