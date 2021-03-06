<?php

namespace Blog\Controller;

use Blog\Form\PostForm;
use Blog\Model\Post;
use Blog\Model\PostTable;
use Zend\Db\Exception\RuntimeException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @property  tableGateway
 */
class BlogController extends AbstractActionController
{
    /**
     * @var PostTable
     */
    private $table;

    public function __construct(PostTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        $postTable = $this->table;

        return new ViewModel([
            'posts' => $postTable->fetchAll()
        ]);
    }

    public function addAction()
    {
        $form = new PostForm();
        $form->get('submit')->setValue('Add Post');
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $post = new Post();
        $post->exchangeArray($form->getData());
        $this->table->save($post);
        return $this->redirect()->toRoute('post');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        try {
            $post = $this->table->find($id);
        }catch (\Exception $e) {
            return $this->redirect()->toRoute('post');
        }

        $form = new PostForm();
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Edit Post');

        $request = $this->getRequest();

        if(!$request->isPost()) {
            return [
                'id'=>$id,
                'form'=>$form
            ];
        }

        $form->setData($request->getPost());
        if(!$form->isValid()) {
            return [
                'id'=>$id,
                'form'=>$form
            ];
        }

        $this->table->save($post);
        return $this->redirect()->toRoute('post');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        $this->table->delete($id);
        return $this->redirect()->toRoute('post');
    }

}