<?php

namespace Nightlife\Controller;

use Indigo;
use Indigo\Template;
use Indigo\Db;
use Indigo\Exception;

class Article extends Indigo\Controller
{
    public static $routes = [
        '/article' => [
            'page' => 'view_all'
        ],
        '/article/{id}' => [
            'page' => 'view'
        ],
        '/article/{id}/edit' => [
            'page' => 'edit',
        ],
        '/article/{id}/save' => [
            'page' => 'save'
        ],
    ];

    public function view_all($request)
    {
        $query = Db::factory()->createQuery();
        $query->select()->from('article');

        $articles = $query->execute();

        $template = Template::factory()->createView('article/all');
        $template->articles = $articles;

        return $template->render();
    }

    public function view($request)
    {
        $query = Db::factory()->createQuery();
        $query->select()->from('article')->where('id', '=', $request['args']['id']);

        $articles = $query->execute();

        if ($articles) {
            $template = Template::factory()->createView('article/view');
            $template->article = $articles[0];

            return $template->render();
        } else {
            return $this->_article_not_found($request);
        }
    }

    public function edit($request)
    {
        $query = Db::factory()->createQuery();
        $query->select()->from('article')->where('id', '=', $request['args']['id']);

        $articles = $query->execute();

        if ($articles) {
            $template = Template::factory()->createView('article/edit');
            $template->article = $articles[0];

            return $template->render();
        } else {
            return $this->_article_not_found($request);
        }
    }

    public function save($request)
    {
        if ($request['method'] != 'POST') {
            throw new Exception\Auth();
        }

        $query = Db::factory()->createQuery();
        $query->update('article')->set($request['post'])->where('id', '=', $request['args']['id']);

        $query->execute(); 

        // this line is absolutely not staying. i just can't yet decide how i want to handle
        // page redirects
        header('Location: /article/' . $request['args']['id']);
        die;
    }

    protected function _article_not_found($request)
    {

    }
}
