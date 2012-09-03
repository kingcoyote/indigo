<?php

namespace Nightlife\Controller;

use Indigo;
use Indigo\Template;
use Indigo\Db;
use Indigo\Exception;

class Article extends Indigo\Controller
{
    public static $routes = [
        'article' => [
            'page' => 'view_all'
        ],
        'article/add' => [
            'page' => 'add'
        ],
        'article/{id}' => [
            'page' => 'view'
        ],
        'article/{id}/edit' => [
            'page' => 'edit',
        ],
        'article/{id}/save' => [
            'page' => 'save'
        ],
        'article/{id}/delete' => [
            'page' => 'delete'
        ],
    ];

    // article
    public function view_all($request, $response)
    {
        $query = Db::factory()->createQuery();
        $query->select()->from('article');

        $articles = $query->execute();

        $template = Template::factory()->createView('article/all');
        $template->articles = $articles;

        $response->set('content', $template->render());

        return $response;
    }

    // article/{id}
    public function view($request, $response)
    {
        $query = Db::factory()->createQuery();
        $query->select()->from('article')->where('id', '=', $request->get('args')['id']);

        $articles = $query->execute();

        if ($articles) {
            $template = Template::factory()->createView('article/view');
            $template->article = $articles[0];

            $response->set('content', $template->render());
        } else {
            $response->set('content', $this->_article_not_found($request));
            $response->set('http_code', $response::HTTP_404);
        }

        return $response;
    }

    // article/{id}/edit
    public function edit($request, $response)
    {
        $query = Db::factory()->createQuery();
        $query->select()->from('article')->where('id', '=', $request->get('args')['id']);

        $articles = $query->execute();

        if ($articles) {
            $template = Template::factory()->createView('article/edit');
            $template->article = $articles[0];

            $response->set('content', $template->render());
        } else {
            $response->set('content', $this->_article_not_found($request));
            $response->set('http_code', $response::HTTP_404);
        }

        return $response;
    }

    // article/{id}/save
    public function save($request, $response)
    {
        if ($request->get('method') != 'POST') {
            throw new Exception\Auth();
        }

        $query = Db::factory()->createQuery();
        $query->update('article')->set($request->get('post'))->where('id', '=', $request->get('args')['id']);

        $query->execute(); 

        // this line is absolutely not staying. i just can't yet decide how i want to handle
        // page redirects
        $response->redirect('/article');
    }

    // article/new
    public function add($request, $response)
    {
        if ($request->get('method') === 'GET') {
            $template = Indigo\Template::factory()->createView('article/new');
            $response->set('content', $template->render());
        } else {
            $query = Indigo\Db::factory()->createQuery();
            $query->insert('article')->values($request->get('post'));
            $article_id = $query->execute();

            $response->redirect('/article/' . $article_id);
        }
        return $response;
    }

    public function delete($request, $response)
    {
                
        if ($request->get('method') === 'GET') {
            $template = Indigo\Template::factory()->createView('article/delete');
            
            $template->article = Indigo\Db::factory()->createQuery()
                ->select()->from('article')->where('id', '=', $request->get('args')[id])
                ->execute()[0];

            $response->set('content', $template->render());
        } else {
            Indigo\Db::factory()->createQuery()
                ->delete('article')->where('id', '=', $request->get('post')['id'])
                ->execute();

            $response->redirect('/article');
        }
        return $response;
    }

    protected function _article_not_found($request)
    {
        return 'The requested article does not exist';
    }
}
