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
	 * @param string $cdbId
	 * @return string
	 */
	public function getCdbId($cdbId) {
		return $this->cdbId;
	}

	/**
	 * getExternalId().
	 * @param string $externalId
	 * @return string
	 */
	public function getExternalId($externalId) {
		return $this->externalId;
	}

	/**
	 * getTitle().
	 * @param string $title
	 * @return string
	 */
	public function getTitle($title) {
		return $this->title;
	}

}
