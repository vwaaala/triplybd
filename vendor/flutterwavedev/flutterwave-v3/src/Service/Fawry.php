<?php

namespace Flutterwave\Service;

use Flutterwave\Contract\ConfigInterface;
use Flutterwave\Contract\Payment;
use Flutterwave\EventHandlers\GooglePayEventHandler;
use Flutterwave\Entities\Payload;
use Flutterwave\Traits\Group\Charge;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientExceptionInterface;
use stdClass;

class Fawry extends Service implements Payment
{
    use Charge;

    public const TYPE = 'fawry_pay';
    private GooglePayEventHandler $eventHandler;

    public function __construct(?ConfigInterface $config = null)
    {
        parent::__construct($config);
        $endpoint = $this->getEndpoint();
        $this->url = $this->baseUrl . '/' . $endpoint . '?type=';
        $this->eventHandler = new GooglePayEventHandler($config);
    }

    /**
     * @return array
     *
     * @throws GuzzleException
     */
    public function initiate(Payload $payload): array
    {
        return $this->charge($payload);
    }

    /**
     * @param  Payload $payload
     * @return array
     *
     * @throws ClientExceptionInterface
     */
    public function charge(Payload $payload): array
    {
        $this->logger->notice('Google Service::Started Charging Process ...');

        $payload = $payload->toArray();

        if($payload['currency'] !== 'EGP') {
            throw new \InvalidArgumentException("Invalid currency. This transaction is only allowed for EGP");
        }

        //request payload
        $body = $payload;

        unset($body['country']);
        unset($body['address']);

        $this->eventHandler::startRecording();
        $request = $this->request($body, 'POST', self::TYPE);
        $this->eventHandler::setResponseTime();
        return $this->handleAuthState($request, $body);
    }

    public function save(callable $callback): void
    {
        // TODO: Implement save() method.
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    private function handleAuthState(stdClass $response, array $payload): array
    {
        return $this->eventHandler->onAuthorization($response, ['logger' => $this->logger]);
    }
}