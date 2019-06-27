<?php


namespace Core\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ClientSecret extends Type
{
    const NAME = 'clientsecret';

    protected $config;

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[] $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return sprintf('TEXT');
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     *
     * @todo Needed?
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * Operation that runs when the value is pulled out of the database
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|void
     */
    public function convertToPhpValue($value, AbstractPlatform $platform)
    {
        $decryptedValue = openssl_decrypt(
            base64_decode($value),
            $this->getConfig('method'),
            $this->getKey(),
            0,
            $this->getIv()
        );

        return $decryptedValue;
    }

    /**
     * Operation that runs when the value is inserted into the database
     *
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|void
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        $encryptedValue = openssl_encrypt($value,
            $this->getConfig('method'),
            $this->getKey(),
            0,
            $this->getIv());

        return base64_encode($encryptedValue);
    }

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getKey() : string
    {
        return hash('sha256', $this->getConfig('key'));
    }

    /**
     * @return string
     */
    public function getIv() : string
    {
        return substr(hash('sha256', $this->getConfig('iv')), 0, 16);
    }

    /**
     * @param string $key
     * @return string
     */
    public function getConfig(string $key = null)
    {
        if($this->config == null) {
            $config = include __DIR__ . '/../../../../config/autoload/encryption.local.php';
            $this->setConfig($config);
        }

        if($key != null) {
            return $this->config[$key];
        }

        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }
}
