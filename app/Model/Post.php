<?php
class Post extends AppModel {

	public function isOwnedBy($post, $user) {//ユーザーの制限、特定のユーザは登録できる
    return $this->field('id', array('id' => $post, 'user_id' => $user)) !== false;
	}
	//バリデーション、制限
    public $validate = array(
        'title' => array(
            'rule' => 'notBlank'
        ),
        'body' => array(
            'rule' => 'notBlank'
        )
    );
}