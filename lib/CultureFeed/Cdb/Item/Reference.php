<?php

/**
 * Class CultureFeed_Cdb_Item_Reference
 *
 * Holds references between different Cdb Items.
 */
Class CultureFeed_Cdb_Item_Reference {

	private $title = '';
	private $cdbId = '';
	private $externalId = '';

	/**
	 * Constructor.
	 *
	 * @param string $cdbId
	 * @param string $title
	 * @param string $externalId
	 */
	public function __construct($cdbId, $title = '', $externalId = '') {
		$this->cdbId = $cdbId;
		$this->title = $title;
		$this->externalId = $externalId;
	}

	/**
	 * getCdbId().
	 * 
	 * @return string $cdbId
	 */
	public function getCdbId() {
		return $this->cdbId;
	}

	/**
	 * setCdbId().
	 * 
	 * @param string $cdbId
	 * @return string
	 */
	public function setCdbId($cdbId) {
		$this->cdbId = $cdbId;
	}

	/**
	 * getExternalId().
	 * 
	 * @return string
	 */
	public function getExternalId() {
		return $this->externalId;
	}

	/**
	 * setExternalId().
	 * 
	 * @param string $externalId
	 * @return string
	 */
	public function setExternalId($externalId) {
		$this->externalId = $externalId;
	}

	/**
	 * getTitle().
	 * 
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * getTitle().
	 * @param string $title
	 * @return string
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

}
