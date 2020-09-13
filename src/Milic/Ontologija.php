<?php

namespace Milic;

/**
 * @Entity @Table(name="ontologija")
 **/

class Ontologija 
{
    /** @id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /**
    * @Column(type="string")
    */
    private $resourceName;

    /**
    * @Column(type="string")
    */
    private $resourceType;

    /**
    * @Column(type="text")
    */
	private $resourceData;
	
	// getteri i setteri
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

  	public function getResourceName(){
		return $this->resourceName;
	}

	public function setResourceName($resourceName){
		$this->resourceName = $resourceName;
	}

  	public function getResourceType(){
    	return $this->resourceType;
  	}

  	public function setResourceType($resourceType){
		$this->resourceType = $resourceType;
	}

  	public function getResourceData(){
  		return $this->resourceData;
  	}

  	public function setResourceData($resourceData){
		$this->resourceData = $resourceData;
  	}
  
  	public function setData($data) {
		foreach($data as $key => $val){
			$this->{$key} = $val;
		}
	}
}
