<?php declare(strict_types=1);

namespace Jtrw\SslCertificate\ValuesObject;

use Jtrw\SslCertificate\Exceptions\WebsiteHostNotFound;

/**
 * Class WebSite
 * @package Jtrw\SslCertificate\ValuesObject
 */
class Url implements ValueObjectInterface
{
    /**
     *
     */
    protected const DEFAULT_SCHEME = "https://";
    
    /**
     * @var string
     */
    protected string $value;
    
    /**
     * WebSite constructor.
     * @param string $value
     * @throws WebsiteHostNotFound
     */
    public function __construct(string $value)
    {
        $value = $this->getPreparedValue($value);
        $this->value = $value;
    } // end __construct
    
    /**
     * @param string $value
     * @return string
     * @throws WebsiteHostNotFound
     */
    protected function getPreparedValue(string $value): string
    {
        $parts = parse_url($value);
        
        $host = $parts['host'] ?? '';
        if (empty($host) && !empty($parts['path'])) {
            $host = $parts['path'];
        }
        
        if (empty($host)) {
            throw new WebsiteHostNotFound('Host not found');
        }
        
        return static::DEFAULT_SCHEME.$host;
    } // end getPreparedValue
    
    /**
     * @return string
     */
    public function toNative(): string
    {
        return $this->value;
    } // end toNative
}
