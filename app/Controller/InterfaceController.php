<?php

namespace App\Controller;


/**
 * Class CustomerController
 * @package App\Controller\System
 */
interface InterfaceController
{

    /**
     * só html chamando search(); via ajax
     *
     * @param $request
     * @param $response
     */
    public function index($request, $response);

    /**
     * query de pesquisa na chamada do ajax
     *
     *
     * @param $request
     * @param $response
     */
    public function search($request, $response);

    /**
     * formulario em branco
     * submit post();
     *
     * @param $request
     * @param $response
     */
    public function form($request, $response);

    /**
     * get by hash com form de edicacao
     * submit put();
     *
     * @param $request
     * @param $response
     * @param null $user
     */
    public function get($request, $response, $user = null);

    /**
     * chamada do servico de criacao
     *
     * @param $request
     * @param $response
     */
    public function post($request, $response);

    /**
     * chamada do servico de edicacao
     *
     * @param $request
     * @param $response
     * @param null $user
     */
    public function put($request, $response, $user = null);

}
