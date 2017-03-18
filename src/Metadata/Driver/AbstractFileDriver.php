<?php

namespace Metadata\Driver;

/**
 * Base file driver implementation.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
abstract class AbstractFileDriver implements AdvancedDriverInterface
{
    /**
     * @var FileLocatorInterface|FileLocator
     */
    private $locator;

    /**
     * Default meta data
     *
     * @var array
     */
    private $defaults;

    public function __construct(FileLocatorInterface $locator, array $defaults = [])
    {
        $this->locator = $locator;
        $this->defaults = $defaults;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        if (null === $path = $this->locator->findFileForClass($class, $this->getExtension())) {
            return null;
        }

        return $this->loadMetadataFromFile($class, $path);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllClassNames()
    {
        if (!$this->locator instanceof AdvancedFileLocatorInterface) {
            throw new \RuntimeException('Locator "%s" must be an instance of "AdvancedFileLocatorInterface".');
        }

        return $this->locator->findAllClasses($this->getExtension());
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

    /**
     * Parses the content of the file, and converts it to the desired metadata.
     *
     * @param \ReflectionClass $class
     * @param string           $file
     *
     * @return \Metadata\ClassMetadata|null
     */
    abstract protected function loadMetadataFromFile(\ReflectionClass $class, $file);

    /**
     * Returns the extension of the file.
     *
     * @return string
     */
    abstract protected function getExtension();
}
