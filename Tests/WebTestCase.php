<?php

namespace Tests;

abstract class WebTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @return \Yee\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $formVars = [])
    {
        $method = strtoupper($requestMethod);

        $options = array(
            'REQUEST_METHOD' => $method,
            'PATH_INFO' => $requestUri,
            'REQUEST_URI' => $requestUri,
        );

        if ($method === 'GET') {
            $options['QUERY_STRING'] = http_build_query($formVars);
        } else {
            $options['yee.input'] = http_build_query($formVars);
        }

        // Create a mock environment for testing with
        $environment = \Yee\Environment::mock($options);

        // Instantiate the application
        $app = new \Yee\Yee(array(
            'version' => '0.0.0',
            'debug' => false,
            'mode' => 'testing'
        ));

        $app->view(new \Yee\Views\Twig());

        new \Yee\Managers\RoutingCacheManager(
                array(
            'cache' => __DIR__ . '/../cache/routing',
            'controller' => array(__DIR__ . '/../App/Controllers')
                )
        );

        $request = $app->request();
        $response = $app->response();

        ob_start();
        $app->execute();
        ob_end_clean();

        return $response;
    }

}
