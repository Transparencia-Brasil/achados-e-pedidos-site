<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Home', 'action' => 'index', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});

//Router::connect('/api/taxaDeAtendimentoPorAno', array('controller' => 'Dados', 'action' => 'TaxaDeAtendimentoPorAno'));
// Versão 2.0 dos Dados para o Atendimento de Pedidos por Ano
Router::connect('/api/v2/PedidosAtendimentoPorAno', array('controller' => 'Dados', 'action' => 'PedidosAtendimentoPorAno_V2'));

// -
//Router::connect('/api/pedidosPorUFPoderENivel', array('controller' => 'Dados', 'action' => 'PedidosPorUFPoderENivel'));
Router::connect('/api/pedidosPorUFPoderENivelEStatus', array('controller' => 'Dados', 'action' => 'PedidosPorUFPoderENivelEStatus'));
Router::connect('/api/PedidosAtendimentoPorAno', array('controller' => 'Dados', 'action' => 'PedidosAtendimentoPorAno'));
Router::connect('/api/sumario', array('controller' => 'Dados', 'action' => 'Sumario'));
Router::connect('/api/pedidosTempoMedioDeTramitacao', array('controller' => 'Dados', 'action' => 'PedidosTempoMedioDeTramitacao'));
Router::connect('/api/taxaDeReversao', array('controller' => 'Dados', 'action' => 'taxaDeReversao'));

// atalhos SEO
Router::connect('/esqueci-a-senha', array('controller' => 'EsqueciASenha', 'action' => 'index'));
Router::connect('/esqueci-a-senha/nova-senha/:chave/', array('controller' => 'EsqueciASenha', 'action' => 'novasenha'), ['pass'=> ['chave']]);

Router::connect('/termos-de-uso', array('controller' => 'Institucional', 'action' => 'politicadeuso'));
Router::connect('/termosdeprivacidade', array('controller' => 'Institucional', 'action' => 'termosdeprivacidade'));
Router::connect('/politica-de-privacidade', array('controller' => 'Institucional', 'action' => 'termosdeprivacidade'));
Router::connect('/na-midia', array('controller' => 'NaMidia', 'action' => 'index'));
Router::connect('/dados', array('controller' => 'Dados', 'action' => 'index'));
Router::connect('/newsletter', array('controller' => 'Newsletter', 'action' => 'index'));
Router::connect('/newsletter/arquivo', array('controller' => 'Newsletter', 'action' => 'arquivo'));
Router::connect('/termos', array('controller' => 'Institucional', 'action' => 'termos'));
Router::connect('/login', array('controller' => 'Login', 'action' => 'Logar', 'prefix' => 'minhaconta'));

Router::connect('/busca/:tipo', ['controller' => 'Busca', 'action' => 'index'], ['pass'=> ['tipo']]);
Router::connect('/usuarios/:slug/:tipo', ['controller' => 'Usuarios', 'action' => 'relacionamento'], ['pass'=> ['slug','tipo']]);

Router::connect('/pedidos/busca-avancada', ['controller' => 'Pedidos', 'action' => 'buscaAvancada']);
Router::connect('/pedidos/:slug', ['controller' => 'Pedidos', 'action' => 'detalhe'], ['pass'=> ['slug']]);
Router::connect('/agentes/:slug', ['controller' => 'Agentes', 'action' => 'detalhe'], ['pass'=> ['slug']]);
Router::connect('/usuarios/:slug', ['controller' => 'Usuarios', 'action' => 'detalhe'], ['pass'=> ['slug']]);
Router::connect('/na-midia/:slug', ['controller' => 'NaMidia', 'action' => 'detalhe'], ['pass'=> ['slug']]);
Router::connect('/na-midia/:slug', ['controller' => 'NaMidia', 'action' => 'detalhe'], ['pass'=> ['slug']]);

/*ATALHOS DA MINHA-CONTA - FRONT END*/
Router::connect('/minha-conta', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta'));
Router::connect('/minhaconta', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta'));
Router::connect('/minha-conta/meus-pedidos', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta', 1));
Router::connect('/minha-conta/perfil', array('controller' => 'Perfil', 'action' => 'index', 'prefix' => 'minhaconta'));
Router::connect('/minha-conta/logout', array('controller' => 'Login', 'action' => 'logout', 'prefix' => 'minhaconta'));
Router::connect('/minha-conta/pedidos/editar/:slug', ['controller' => 'Pedidos', 'action' => 'editar', 'prefix' => 'minhaconta'], ['pass'=> ['slug']]);

//Scripts
Router::connect('/scriptCriaAnexosES',array('controller' => 'Script',  'action' => 'criaAnexosES'));


/*ATALHOS DA MINHA-CONTA - FRONT END*/
Router::connect('/minha-conta', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta'));
Router::connect('/minhaconta', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta'));
Router::connect('/minha-conta/meus-pedidos', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'minhaconta', 1));
Router::connect('/minha-conta/perfil', array('controller' => 'Perfil', 'action' => 'index', 'prefix' => 'minhaconta'));
Router::connect('/minha-conta/logout', array('controller' => 'Login', 'action' => 'logout', 'prefix' => 'minhaconta'));
Router::connect('/minha-conta/pedidos/editar/:slug', ['controller' => 'Pedidos', 'action' => 'editar', 'prefix' => 'minhaconta'], ['pass'=> ['slug']]);


// atalho para o painel
Router::connect('/painel-ctl', array('controller' => 'Home', 'action' => 'index', 'prefix' => 'admin'));

Router::prefix('admin', function ($routes) {
    // All routes here will be prefixed with '/admin'
    // And have the prefix => admin route element added.
    $routes->connect('/:controller/', ['action' => 'index'],['routeClass' => 'InflectedRoute']);
    $routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);
    $routes->fallbacks('InflectedRoute');
});

Router::prefix('minhaconta', function ($routes) {
    $routes->connect('/:controller/', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);
    $routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);
    $routes->fallbacks('InflectedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
