<?php

class Model {
    
    protected $_connection;
    
    public function __construct() {
        include 'config.php';
        $this->_connection = mysqli_connect($mysql_db['host'], $mysql_db['username'], $mysql_db['password'], $mysql_db['database']);
        // Check connection
        if (mysqli_connect_errno())
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    function addProjectPhaseChangedEvent($params) {

        $query = "INSERT INTO project_phasechanged (timestamp, project_id, phase_name, org_id, webhook_url)
                    VALUES (".$params['timestamp'].",".$params['project_id'].",'".$params['phase_name']."',".$params['org_id'].",'".$params['webhook_url']."')";
        
        if ($this->_connection->query($query) === TRUE)
            echo "New record created successfully";
        else
            echo "Error: " . $query . "<br>" . $conn->error;
    }
    
    function addCollectionItemCreatedEvent($params) {

        $query = "INSERT INTO collectionitem_created (timestamp, project_id, section_selector, demand_type, collectionitem_id, org_id, webhook_url)
                    VALUES (".$params['timestamp'].",".$params['project_id'].",'".$params['section_selector']."','".$params['demand_type']."','".$params['collectionitem_id']."',".$params['org_id'].",'".$params['webhook_url']."')";
        
        if ($this->_connection->query($query) === TRUE)
            echo "New record created successfully";
        else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
	
	function addCollectionItemUpdatedEvent($params) {

        $query = "INSERT INTO collectionitem_updated (timestamp, project_id, section_selector, collectionitem_id, org_id, webhook_url)
                    VALUES (".$params['timestamp'].",".$params['project_id'].",'".$params['section_selector']."','".$params['collectionitem_id']."',".$params['org_id'].",'".$params['webhook_url']."')";
        
        if ($this->_connection->query($query) === TRUE)
            echo "New record created successfully";
        else
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    function close() {
        $this->_connection->close();
    }
}

?>