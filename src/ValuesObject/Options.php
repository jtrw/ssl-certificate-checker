<?php declare(strict_types=1);
namespace Jtrw\SslCertificate\ValuesObject;

use DateTime;

class Options implements OptionsInterface, ValueObjectInterface
{
    /**
     * @var DateTime|null
     */
    protected ?DateTime $expireDate = null;
    
    /**
     * Options constructor.
     * @param array $options
     * @throws \Exception
     */
    public function __construct(array $options)
    {
        if (!empty($options['expire_date'])) {
            $this->expireDate = new DateTime($options['expire_date']);
        }
    } // end __construct
    
    /**
     * @return bool
     */
    public function isExpireDate(): bool
    {
        return (bool) $this->expireDate;
    } // end isExpireDate
    
    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->expireDate;
    } // end getEndDate
    
    /**
     * @return DateTime[]|null[]
     */
    public function toNative(): array
    {
        return [
            'expire_date' => $this->expireDate
        ];
    } // end toNative
}
