<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_PagePermissions implements CultureFeed_Cdb_IElement
{
    public bool $allowActivities = false;
    public bool $allowComments = false;
    public bool $allowFollowers = false;
    public bool $allowLikes = false;
    public bool $allowMembers = false;
    public bool $allowMessages = false;
    public bool $allowRecommendations = false;

    public function appendToDOM(DOMElement $element): void
    {
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_PagePermissions
    {
        $pagePermissions = new self();

        $pagePermissions->allowActivities = (string) $xmlElement->allowActivities == 'true' ? true : false;
        $pagePermissions->allowComments = (string) $xmlElement->allowComments == 'true' ? true : false;
        $pagePermissions->allowFollowers = (string) $xmlElement->allowFollowers == 'true' ? true : false;
        $pagePermissions->allowLikes = (string) $xmlElement->allowLikes == 'true' ? true : false;
        $pagePermissions->allowMembers = (string) $xmlElement->allowMembers == 'true' ? true : false;
        $pagePermissions->allowMessages = (string) $xmlElement->allowMessages == 'true' ? true : false;
        $pagePermissions->allowRecommendations = (string) $xmlElement->allowRecommendations == 'true' ? true : false;

        return $pagePermissions;
    }
}
