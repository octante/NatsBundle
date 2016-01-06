<?php

/*
 * This file is part of the NatsBundle package.
 *
 * (c) Issel Guberna <issel.guberna@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Octante\NatsBundle\Connection;

class ConnectionWrapper
{
    /**
     * @var
     */
    private $connection;

    /**
     * @var
     */
    private $logger;

    /**
     * @param $connection
     * @param $logger
     */
    public function __construct($connection, $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    /**
     * Return the number of pings.
     *
     * @return int Number of pings
     */
    public function pingsCount()
    {
        return $this->connection->pingsCount();
    }

    /**
     * Return the number of messages published.
     *
     * @return int number of messages published
     */
    public function pubsCount()
    {
        return $this->connection->pubsCount();
    }

    /**
     * Return the number of reconnects to the server.
     *
     * @return int number of reconnects
     */
    public function reconnectsCount()
    {
        return $this->connection->reconnectsCount();
    }

    /**
     * Return the number of subscriptions available.
     *
     * @return int number of subscription
     */
    public function subscriptionsCount()
    {
        return $this->connection->subscriptionsCount();
    }

    /**
     * Return subscriptions list.
     *
     * @return array list of subscription ids
     */
    public function getSubscriptions()
    {
        return $this->connection->getSubscriptions();
    }

    /**
     * Checks if the client is connected to a server.
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->connection->isConnected();
    }

    /**
     * Connect to server.
     *
     * @param integer $timeout Number of seconds until the connect() system call should timeout.
     *
     * @throws \Exception Exception raised if connection fails.
     *
     * @return void
     */
    public function connect($timeout = null)
    {
        $this->connection->connect($timeout);
    }

    /**
     * Sends PING message.
     *
     * @return void
     */
    public function ping()
    {
        $startTime = microtime(true);
        $this->connection->ping();
        $duration = (microtime(true) - $startTime) * 1000;
        $this->logger->logCommand('PING: ', $duration, $this->connection, false);
    }

    /**
     * Request does a request and executes a callback with the response.
     *
     * @param string  $subject  Message topic.
     * @param string  $payload  Message data.
     * @param mixed   $callback Closure to be executed as callback.
     * @param integer $wait     Number of messages to wait for.
     *
     * @return void
     */
    public function request($subject, $payload, $callback, $wait = 1)
    {
        $startTime = microtime(true);
        $this->connection->request($subject, $payload, $callback, $wait);
        $duration = (microtime(true) - $startTime) * 1000;
        $this->logger->logCommand('REQUEST: ', $duration, $this->connection, false);
    }

    /**
     * Publish publishes the data argument to the given subject.
     *
     * @param string $subject Message topic.
     * @param string $payload Message data.
     *
     * @return void
     */
    public function publish($subject, $payload)
    {
        $startTime = microtime(true);
        $this->connection->publish($subject, $payload);
        $duration = (microtime(true) - $startTime) * 1000;
        $this->logger->logCommand('PUBLISH: ' . $subject, $duration, $this->connection, false);
    }

    /**
     * Subscribes to an specific event given a subject.
     *
     * @param string   $subject  Message topic.
     * @param \Closure $callback Closure to be executed as callback.
     *
     * @return string
     */
    public function subscribe($subject, \Closure $callback)
    {
        $startTime = microtime(true);
        $result = $this->connection->subscribe($subject, $callback);
        $duration = (microtime(true) - $startTime) * 1000;
        $this->logger->logCommand('SUBSCRIBE: ' . $subject, $duration, $this->connection, false);
        return $result;
    }

    /**
     * Unsubscribe from a event given a subject.
     *
     * @param string $sid Subscription ID.
     *
     * @return void
     */
    public function unsubscribe($sid)
    {
        $startTime = microtime(true);
        $this->connection->unsubscribe($sid);
        $duration = (microtime(true) - $startTime) * 1000;
        $this->logger->logCommand('UNSUBSCRIBE: ' . $sid, $duration, $this->connection, false);
    }

    /**
     * Waits for messages.
     *
     * @param integer $quantity Number of messages to wait for.
     *
     * @return resource $connection Connection object
     */
    public function wait($quantity = 0)
    {
        return $this->connection->wait($quantity);
    }

    /**
     * Set Stream Timeout.
     *
     * @param integer $seconds Before timeout on stream.
     *
     * @return boolean
     */
    public function setStreamTimeout($seconds)
    {
        return $this->connection->setStreamTimeout($seconds);
    }

    /**
     * Reconnects to the server.
     *
     * @return void
     */
    public function reconnect()
    {
        $this->connection->reconnect();
    }

    /**
     * Close will close the connection to the server.
     *
     * @return void
     */
    public function close()
    {
        $this->connection->close();
    }
}