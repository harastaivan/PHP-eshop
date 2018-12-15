<?php

namespace EShop\Middleware;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use EShop\Model\Customer;

class AuthMiddleware
{
    /**
     * Middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        if (!$request->hasHeader('Authorization')) {
            return $response->withStatus(401);
        }
        $credentials = $this->decodeAuthHeader($request->getHeader('Authorization'));
        $customer = $this->getCustomerByUsernameAndPassword($credentials['username'], $credentials['password']);
        if (!$customer) {
            return $response->withStatus(401);
        }
        $newRequest = $request->withAttribute('customer', $customer);
        $response = $next($newRequest, $response);

        return $response;
    }

    /**
     * Decodes header:
     * Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=
     * @param array $header
     * @return array
     */
    private function decodeAuthHeader($header) {
        $data = [];
        $base64 = explode(' ', $header[0])[1];
        $data['username'] = explode(':', base64_decode($base64))[0];
        $data['password'] = explode(':', base64_decode($base64))[1];
        return $data;
    }

    /**
     * @param string $username
     * @param string $password
     * @return Customer|null
     */
    private function getCustomerByUsernameAndPassword($username, $password) {
        $customers = Customer::getExamples();
        foreach ($customers as $customer) {
            if ($customer->getUsername() == $username && $customer->getPassword() == $password) {
                return $customer;
            }
        }
        return null;
    }
}