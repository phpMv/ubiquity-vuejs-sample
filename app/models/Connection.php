<?php
namespace models;

use Ubiquity\attributes\items\Id;
use Ubiquity\attributes\items\Column;
use Ubiquity\attributes\items\Validator;
use Ubiquity\attributes\items\Transformer;
use Ubiquity\attributes\items\Table;
use Ubiquity\attributes\items\ManyToOne;
use Ubiquity\attributes\items\JoinColumn;

#[Table(name: "connection")]
class Connection{
	
	#[Id()]
	#[Column(name: "id",dbType: "int(11)")]
	#[Validator(type: "id",constraints: ["autoinc"=>true])]
	private $id;

	
	#[Column(name: "dateCo",dbType: "datetime")]
	#[Validator(type: "type",constraints: ["ref"=>"dateTime","notNull"=>true])]
	#[Transformer(name: "datetime")]
	private $dateCo;

	
	#[Column(name: "url",dbType: "varchar(255)")]
	#[Validator(type: "url",constraints: ["notNull"=>true])]
	#[Validator(type: "length",constraints: ["max"=>255])]
	private $url;

	
	#[ManyToOne()]
	#[JoinColumn(className: "models\\User",name: "idUser")]
	private $user;


	public function getId(){
		return $this->id;
	}


	public function setId($id){
		$this->id=$id;
	}


	public function getDateCo(){
		return $this->dateCo;
	}


	public function setDateCo($dateCo){
		$this->dateCo=$dateCo;
	}


	public function getUrl(){
		return $this->url;
	}


	public function setUrl($url){
		$this->url=$url;
	}


	public function getUser(){
		return $this->user;
	}


	public function setUser($user){
		$this->user=$user;
	}


	 public function __toString(){
		return ($this->url??'no value').'';
	}

}