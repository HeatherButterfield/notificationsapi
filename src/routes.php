<?php
// Routes
require_once 'services/TeamService.php';
require_once 'services/CoachService.php';
require_once 'services/PlayerService.php';

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
		$app->get('/teams', function ($request) {
            $svc = new TeamService(NULL, $request);
                 return $svc->list();
        });
        $app->get('/teams/{id}', function ($request) {
            $svc = new TeamService(NULL, $request);
                 return $svc->read();
        });
        $app->post('/teams', function ($request) {
            $svc = new TeamService(NULL, $request);
                 return $svc->create();
        });
        $app->put('/teams/{id}', function ($request) {
            $svc = new TeamService(NULL, $request);
                 return $svc->update();
        });
        $app->delete('/teams', function ($request) {
            $svc = new TeamService(NULL, $request);
                 return $svc->delete();
        });
       
        $app->get('/players', function ($request) {
            $svc = new PlayerService(NULL, $request);
                 return $svc->list();
        });
        $app->get('/players/{id}', function ($request) {
            $svc = new PlayerService(NULL, $request);
                 return $svc->read();
        });
        $app->post('/players', function ($request) {
            $svc = new PlayerService(NULL, $request);
                 return $svc->create();
        });
        $app->put('/players/{id}', function ($request) {
            $svc = new PlayerService(NULL, $request);
                 return $svc->update();
        });
        $app->delete('/players/{id}', function ($request) {
            $svc = new PlayerService(NULL, $request);
                 return $svc->delete();
        });
        
        $app->get('/coaches', function ($request) {
            $svc = new CoachService(NULL, $request);
                 return $svc->list();
        });
        $app->get('/coaches/{id}', function ($request) {
            $svc = new CoachService(NULL, $request);
                 return $svc->read();
        });
        $app->post('/coaches', function ($request) {
            $svc = new CoachService(NULL, $request);
                 return $svc->create();
        });
        $app->put('/coaches/{id}', function ($request) {
            $svc = new CoachService(NULL, $request);
                 return $svc->update();
        });
        $app->delete('/coaches/{id}', function ($request) {
            $svc = new CoachService(NULL, $request);
                 return $svc->delete();
        });
	});
 });
    
?>
