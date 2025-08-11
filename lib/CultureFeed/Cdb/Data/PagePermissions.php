<?php

/**
 * @class
 * Representation of an PagePermissions element in the cdb xml.
 */
class CultureFeed_Cdb_Data_PagePermissions implements CultureFeed_Cdb_IElement
{
    /**
     * Indicates if the page allows activities.
     * @var Boolean
     */
    public $allowActivities = false;

    /**
     * Indicates if the page allows commenting.
     * @var Boolean
     */
    public $allowComments = false;

    /**
     * Indicates if the page allows followers.
     * @var Boolean
     */
    public $allowFollowers = false;

    /**
     * Indicates if the page allows liking.
     * @var Boolean
     */
    public $allowLikes = false;

    /**
     * Indicates if the page allows to become member.
     * @var Boolean
     */
    public $allowMembers = false;

    /**
     * Indicates if the page allows to message.
     * @var Boolean
     */
    public $allowMessages = false;

    /**
     * Indicates if the page allows to recommend a page.
     * @var Boolean
     */
    public $allowRecommendations = false;

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_PagePermissions
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $pagePermissions = new self();

        $pagePermissions->allowActivities = (string) $xmlElement->allowActivities == "true" ? true : false;
        $pagePermissions->allowComments = (string) $xmlElement->allowComments == "true" ? true : false;
        $pagePermissions->allowFollowers = (string) $xmlElement->allowFollowers == "true" ? true : false;
        $pagePermissions->allowLikes = (string) $xmlElement->allowLikes == "true" ? true : false;
        $pagePermissions->allowMembers = (string) $xmlElement->allowMembers == "true" ? true : false;
        $pagePermissions->allowMessages = (string) $xmlElement->allowMessages == "true" ? true : false;
        $pagePermissions->allowRecommendations = (string) $xmlElement->allowRecommendations == "true" ? true : false;

        return $pagePermissions;
    }
}
