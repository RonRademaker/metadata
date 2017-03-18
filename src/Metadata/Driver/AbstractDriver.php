<?php

namespace Metadata\Driver;

/**
 * Base driver for metadata
 *
 * @author Ron Rademaker
 */
abstract class AbstractDriver implements DriverInterface
{
    /**
     * Default meta data
     *
     * @var array
     */
    private $defaults;

    /**
     * AbstractDriver constructor.
     *
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->defaults = $defaults;
    }

    /**
     * Get a default metadata option.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getDefaultMetadata($key)
    {
        if (array_key_exists($key, $this->defaults)) {
            return $this->defaults[$key];
        }
    }
}
