<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Model\Application;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    public function __construct(AdapterInterface $adapter) {
        $this->adapter = $adapter;
    }
    
    public function indexAction()
    {
        $posts = new Application($this->adapter);

        $results = $posts->fetchAll();

        return new ViewModel([
            'posts' => $results
        ]);
    }

    public function newAction()
    {
        $post = new Application($this->adapter);
        
        if ($this->getRequest()->isPost()) {
            $titulo = $this->getRequest()->getPost('title', null);
            $descricao = $this->getRequest()->getPost('description', null);
            $id_categoria = $this->getRequest()->getPost('category_id', null);

            $data = [
                'title' => $titulo,
                'description' => $descricao,
                'category_id' => $id_categoria
            ];

            $post->insertNoticia($data);

            return $this->redirect()->toRoute('home');
        }

        $results = $post->showCategories();

        return new ViewModel([
            'categories' => $results
        ]);
    }

    public function deleteAction()
    {
        $post = new Application($this->adapter);
        
        $id = $this->params('id');

        $post->deleteNoticia($id);

        return $this->redirect()->toRoute('home');
    }

    public function showAction()
    {
        $post = new Application($this->adapter);

        $id = $this->params('id');

        $result = $post->showNoticia($id);

        return new ViewModel([
            'post' => $result
        ]);
    }

    public function editAction()
    {
        $post = new Application($this->adapter);
        $id = $this->params('id');
        
        if ($this->getRequest()->isPost()) {
            $titulo = $this->getRequest()->getPost('title', null);
            $descricao = $this->getRequest()->getPost('description', null);
            $id_categoria = $this->getRequest()->getPost('category_id', null);

            $data = [
                'title' => $titulo,
                'description' => $descricao,
                'category_id' => $id_categoria
            ];

            $post->updateNoticia($data, $id);

            return $this->redirect()->toRoute('home');
        }

        $noticia = $post->showNoticia($id);
        $results = $post->showCategories();

        return new ViewModel([
            'post' => $noticia,
            'categories' => $results
        ]);
    }
}