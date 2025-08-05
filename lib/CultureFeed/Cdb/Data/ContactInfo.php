<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_ContactInfo implements CultureFeed_Cdb_IElement
{
    /**
     * @var CultureFeed_Cdb_Data_Address[]
     */
    private array $addresses = [];

    /**
     * @var CultureFeed_Cdb_Data_Phone[]
     */
    private array $phones = [];

    /**
     * @var CultureFeed_Cdb_Data_Mail[]
     */
    private array $mails = [];

    /**
     * @var CultureFeed_Cdb_Data_Url[]
     */
    private array $urls = [];

    /**
     * @return CultureFeed_Cdb_Data_Address[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @return CultureFeed_Cdb_Data_Phone[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * @return CultureFeed_Cdb_Data_Mail[]
     */
    public function getMails(): array
    {
        return $this->mails;
    }

    /**
     * @return CultureFeed_Cdb_Data_Url[]
     */
    public function getUrls(): array
    {
        return $this->urls;
    }

    public function addAddress(CultureFeed_Cdb_Data_Address $address): void
    {
        $this->addresses[] = $address;
    }

    public function removeAddress(int $index): void
    {
        if (!isset($this->addresses[$index])) {
            throw new Exception('Trying to remove an unexisting address.');
        }

        unset($this->addresses[$index]);
    }

    public function addPhone(CultureFeed_Cdb_Data_Phone $phone): void
    {
        $this->phones[] = $phone;
    }

    public function removePhone(int $index): void
    {
        if (!isset($this->phones[$index])) {
            throw new Exception('Trying to remove an unexisting phone.');
        }

        unset($this->phones[$index]);
    }

    public function deletePhones(): void
    {
        $this->phones = [];
    }

    public function addMail(CultureFeed_Cdb_Data_Mail $mail): void
    {
        $this->mails[] = $mail;
    }

    public function removeMail(int $index): void
    {
        if (!isset($this->mails[$index])) {
            throw new Exception('Trying to remove an unexisting mail.');
        }

        unset($this->mails[$index]);
    }

    public function deleteMails(): void
    {
        $this->mails = [];
    }

    public function addUrl(CultureFeed_Cdb_Data_Url $url): void
    {
        $this->urls[] = $url;
    }

    public function removeUrl(int $index): void
    {
        if (!isset($this->urls[$index])) {
            throw new Exception('Trying to remove an unexisting url.');
        }

        unset($this->urls[$index]);
    }

    public function deleteUrls(): void
    {
        $this->urls = [];
    }

    /**
     * @return array<string, array<string>>
     */
    public function getReservationInfo(): array
    {
        $info = [];

        foreach ($this->urls as $url) {
            if ($url->isForReservations()) {
                $info['url'][] = $url->getUrl();
            }
        }

        foreach ($this->phones as $phone) {
            if ($phone->isForReservations()) {
                $info['phone'][] = $phone->getNumber();
            }
        }

        foreach ($this->mails as $mail) {
            if ($mail->isForReservations()) {
                $info['mails'][] = $mail->getMailAddress();
            }
        }

        return $info;
    }

    /**
     * @return array<string, array<string>>
     */
    public function getMainInfo(): array
    {
        $info = [];

        foreach ($this->urls as $url) {
            if ($url->isMain()) {
                $info['url'][] = $url->getUrl();
            }
        }

        foreach ($this->phones as $phone) {
            if ($phone->isMainPhone()) {
                $info['phone'][] = $phone->getNumber();
            }
        }

        foreach ($this->mails as $mail) {
            if ($mail->isMainMail()) {
                $info['mails'][] = $mail->getMailAddress();
            }
        }

        return $info;
    }

    public function getReservationUrl(): ?string
    {
        foreach ($this->urls as $url) {
            if ($url->isForReservations()) {
                return $url->getUrl();
            }
        }

        return null;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $contactElement = $dom->createElement('contactinfo');

        foreach ($this->addresses as $address) {
            $address->appendToDom($contactElement);
        }

        foreach ($this->mails as $mail) {
            $mail->appendToDom($contactElement);
        }

        foreach ($this->phones as $phone) {
            $phone->appendToDom($contactElement);
        }

        foreach ($this->urls as $url) {
            $url->appendToDom($contactElement);
        }

        $element->appendChild($contactElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_ContactInfo
    {
        $contactInfo = new CultureFeed_Cdb_Data_ContactInfo();

        if (!empty($xmlElement->address)) {
            $contactInfo->addAddress(
                CultureFeed_Cdb_Data_Address::parseFromCdbXml(
                    $xmlElement->address
                )
            );
        }

        if (!empty($xmlElement->mail)) {
            foreach ($xmlElement->mail as $mailElement) {
                $contactInfo->addMail(
                    CultureFeed_Cdb_Data_Mail::parseFromCdbXml($mailElement)
                );
            }
        }

        if (!empty($xmlElement->phone)) {
            foreach ($xmlElement->phone as $phoneElement) {
                $contactInfo->addPhone(
                    CultureFeed_Cdb_Data_Phone::parseFromCdbXml($phoneElement)
                );
            }
        }

        if (!empty($xmlElement->url)) {
            foreach ($xmlElement->url as $urlElement) {
                $contactInfo->addUrl(
                    CultureFeed_Cdb_Data_Url::parseFromCdbXml($urlElement)
                );
            }
        }

        return $contactInfo;
    }
}
