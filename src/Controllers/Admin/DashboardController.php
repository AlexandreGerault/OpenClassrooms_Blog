<?php

namespace AGerault\Blog\Controllers\Admin;

use AGerault\Blog\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface;

class DashboardController extends BaseController
{
    public function __invoke(): ResponseInterface
    {
        return $this->render('admin/dashboard.twig.html');
    }
}
