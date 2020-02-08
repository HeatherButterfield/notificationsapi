<?php
// Routes
require_once 'services/CallService.php';

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

    // API group
$app->group('/api', function () use ($app) {
    // Version group
    $app->group('/v1', function () use ($app) {
        
        $app->get('/coaches', function ($request) {
            $svc = new CallService(NULL, $request);
                 return $svc->list();
        });
        $app->get('/coaches/{id}', function ($request) {
            $svc = new CallService(NULL, $request);
                 return $svc->read();
        });
        $app->post('/coaches', function ($request) {
            $svc = new CallService(NULL, $request);
                 return $svc->create();
        });
        $app->put('/coaches/{id}', function ($request) {
            $svc = new CallService(NULL, $request);
                 return $svc->update();
        });
        $app->delete('/coaches/{id}', function ($request) {
            $svc = new CallService(NULL, $request);
                 return $svc->delete();
        });
	});
 });
    
?>
