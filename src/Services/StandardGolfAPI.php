<?php

namespace jtx\foreup\Services;

use jtx\foreup\Interfaces\GolfAPIInterface;

class StandardGolfAPI extends AbstractGolfApi implements GolfAPIInterface
{
    // Normally all this would be in an .env or something. Out of this scope however.
    const USERNAME = 'devtesting';
    const PASSWORD = 'devtesting1';

    const TOKEN_URL = 'https://mobile.foreupsoftware.com/api_rest/index.php/tokens';
    const CREATE_USER_URL = 'https://mobile.foreupsoftware.com/api_rest/index.php/courses/%d/customers';

    /**
     * Get JWT string
     *
     * @return string
     * @throws \Exception
     */
    public function auth(): string
    {
        $res = $this->client->request('POST', self::TOKEN_URL, [
            'headers' => [
                'Content-type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
            ],
            'body' => json_encode(
                [
                    'email' => self::USERNAME,
                    'password' => self::PASSWORD,
                ],
            )
        ]);

        if (!$this->responseOK($res)) {
            throw new \Exception('Invalid Credentials.');
        }

        $contents = $res->getBody()->getContents();
        $decoded = json_decode($contents);

        return $decoded->data->id;
    }

    /**
     * Create user
     *
     * @param string $jwt
     * @param int $courseId
     * @param array $customer
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createUser(string $jwt, int $courseId, array $customer): bool
    {
        // $customer could be a model here and we do some validation, but you said you didn't wanna read API docs,
        // so just gonna assume you know what that array's supposed to look like mostly.
        $body = [
            'type' => 'customer',
            'attributes' => $customer
        ];

        $url = sprintf(self::CREATE_USER_URL, $courseId);
        $res = $this->client->request('POST', $url, [
            'headers' => [
                'x-authorization' => 'Bearer ' . $jwt,
                'Content-type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
            ],
            'body' => json_encode(['data' => $body]),
        ]);

        return $this->responseOK($res);
    }

    /**
     * Just go ahead and do it all at once
     *
     * @param int $courseId
     * @param array $customer
     * @return bool
     * @throws \Exception
     */
    public function createUserOneStep(int $courseId, array $customer): bool
    {
        if (!$jwt = $this->auth()) {
            return false;
        }

        return $this->createUser($jwt, $courseId, $customer);
    }
}
