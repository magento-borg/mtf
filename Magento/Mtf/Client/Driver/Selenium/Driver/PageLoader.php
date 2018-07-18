<?php
/**
 * Copyright © 2017 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Mtf\Client\Driver\Selenium\Driver;

use Magento\Mtf\Client\Driver\Selenium\RemoteDriver;

/**
 * Driver for waiting page load.
 */
class PageLoader implements PageLoaderInterface
{
    /**
     * Remote driver instance.
     *
     * @var RemoteDriver
     */
    private $driver;

    /**
     * Set driver.
     *
     * @param RemoteDriver $driver
     * @return $this
     */
    public function setDriver(RemoteDriver $driver)
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * Wait page to load.
     *
     * @throws \Exception
     * @return void
     */
    public function wait()
    {
        $driver = $this->driver;
        try {
            $this->driver->waitUntil(
                function () use ($driver) {
                    $result = $driver->execute(['script' => "return document['readyState']", 'args' => []]);
                    return $result === 'complete' || $result === 'uninitialized';
                }
            );
        } catch (\Exception $e) {
            throw new \Exception(
                sprintf('Error occurred during waiting for page to load. Message: "%s"', $e->getMessage())
            );
        }
    }
}
