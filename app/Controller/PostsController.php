<?php
class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Flash');
    public $components = array('Flash');

    public function index() {
        $this->set('posts', $this->Post->find('all'));
    }

    public function view($id) {//Posts/view/数字に入る
        if (!$id) {//数字がないとき、エラー表示
            throw new NotFoundException(__('Invalid post'));
        }
		//一つの投稿記事を持ってくる。idの指定のデータベース
        $post = $this->Post->findById($id);
        if (!$post) {//何も入ってなかったらエラー
            throw new NotFoundException(__('Invalid post'));
        }
        //入っていたら、view.ctpに受け渡す。
        $this->set('post', $post);
    }

public function add() {
    if ($this->request->is('post')) {
        //Added this line
        $this->request->data['Post']['user_id'] = $this->Auth->user('id');
        if ($this->Post->save($this->request->data)) {
            $this->Flash->success(__('Your post has been saved.'));
            return $this->redirect(array('action' => 'index'));
        }
    }
}
    
    public function isAuthorized($user) {
    // 登録済ユーザーは投稿できる
    if ($this->action === 'add') {
        return true;
    }

    // 投稿のオーナーは編集や削除ができる
    if (in_array($this->action, array('edit', 'delete'))) {
        $postId = (int) $this->request->params['pass'][0];
        if ($this->Post->isOwnedBy($postId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
}
    
    public function edit($id = null) {//edit のアクション
    if (!$id) {//idが入ってないとき、エラーを吐く
        throw new NotFoundException(__('Invalid post'));
    }

    $post = $this->Post->findById($id);//idに該当するデータベースのデータを変数にする
    if (!$post) {//何も変数に入ってないときにエラーをはく
        throw new NotFoundException(__('Invalid post'));
    }
    
	//リクエストがpostやputならば、レコードを更新する。
    if ($this->request->is(array('post', 'put'))) {
        $this->Post->id = $id;
        if ($this->Post->save($this->request->data)) {
            $this->Flash->success(__('Your post has been updated.'));//文字の表示
            return $this->redirect(array('action' => 'index'));//場所の移動
        }
        $this->Flash->error(__('Unable to update your post.'));//何も入ってないときにエラーを表示
    }

    if (!$this->request->data) {//もし、dataに何も情報が入ってないとき、取得していたポストレコードをそのままセットする.
        $this->request->data = $post;
    }
}

//記事の削除
public function delete($id) {
	//getリクエストを使って削除しようとするとエラーを吐く
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Post->delete($id)) {
        $this->Flash->success(//成功したときに、以下を表示する。
            __('The post with id: %s has been deleted.', h($id))
        );
    } else {
        $this->Flash->error(
            __('The post with id: %s could not be deleted.', h($id))
        );
    }
	//元の場所にもう一度アクセスする。
    return $this->redirect(array('action' => 'index'));
}
}