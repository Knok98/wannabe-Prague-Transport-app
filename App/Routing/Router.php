<?php

declare(strict_types=1);

namespace Idos\Routing;

use Exception;
use Idos\Request;

class Router
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    private const Figures = [
        '~' => '\~',
        '(:int)' => '(\d+)',
        '(:str)' => '([a-zA-Z]+)',
        '(:email)' => '([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-z]{2,}))',
        '(:link)' => '([0-9]+\-[0-9]+)',
    ];


    /**
     * @param RouteSet $registeredRoutes Registered routes in RoutesFactory
     */
    public function __construct(
        private readonly RouteSet $registeredRoutes
    ) {
    }

    /**
     * @param string $requestUri Incoming request method
     * @param string $requestMethod Incoming request method, `GET` or `POST`
     * @throws Exception
     */
    public function match(string $requestUri, string $requestMethod): ?Request
    {
        $figureSearch = array_keys(self::Figures);
        $figureReplace = array_values(self::Figures);

        foreach ($this->registeredRoutes as $route) {
            if (in_array($requestMethod, $route->httpMethods, true) === false) {
                // Method mismatch, skip to next route
                continue;
            }

            $urlPattern = sprintf('~^%s$~D', str_replace($figureSearch, $figureReplace, $route->urlPattern));
            $result = preg_match($urlPattern, $requestUri, $matches);

            if ($result === false) {
                $error = error_get_last()['message'] ?? preg_last_error_msg();
                throw new Exception(
                    "URL pattern '{$route->urlPattern}' cause invalid PCRE syntax: '{$urlPattern}', error: {$error}."
                );
            }

            if(!$result) {
                // Url pattern mismatch, skip to next route
                continue;
            }

            $params = $matches;
            array_shift($params);

            return new Request($route->controller, $route->action, $params, $route);
        }

        return null;
    }
}
